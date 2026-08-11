<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProcessProductImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     */
    public $tries = 3;

    /**
     * The number of seconds to wait before retrying the job.
     */
    public $backoff = [60, 300, 900];

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected int $mediaId,
        protected array $options = []
    ) {
        // Set queue connection
        $this->onQueue('images');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            // Get media object
            $media = Media::find($this->mediaId);
            
            if (!$media) {
                Log::warning('Media not found for processing', [
                    'media_id' => $this->mediaId,
                ]);
                return;
            }

            // Get image processing options
            $maxWidth = $this->options['max_width'] ?? 1920;
            $maxHeight = $this->options['max_height'] ?? 1080;
            $quality = $this->options['quality'] ?? 85;

            // Get file path
            $disk = $media->disk;
            $relativePath = $media->getPathRelativeToRoot();
            
            // Check if file exists
            if (!Storage::disk($disk)->exists($relativePath)) {
                Log::warning('Media file not found', [
                    'media_id' => $this->mediaId,
                    'relative_path' => $relativePath,
                    'disk' => $disk,
                ]);
                return;
            }

            // Get full path for processing
            $fullPath = Storage::disk($disk)->path($relativePath);

            // Check if GD library is available for image processing
            if (extension_loaded('gd')) {
                $this->processWithGD($fullPath, $maxWidth, $maxHeight, $quality);
            } else {
                // If GD is not available, skip processing
                Log::info('GD library not available, skipping image processing', [
                    'media_id' => $this->mediaId,
                ]);
            }

            Log::info('Product image processed successfully', [
                'media_id' => $this->mediaId,
                'file_path' => $relativePath,
            ]);

        } catch (\Exception $e) {
            Log::error('Product image processing failed: ' . $e->getMessage(), [
                'exception' => $e,
                'media_id' => $this->mediaId,
            ]);

            // Re-throw exception to trigger retry
            throw $e;
        }
    }

    /**
     * Process image using GD library (in place).
     */
    protected function processWithGD(string $filePath, int $maxWidth, int $maxHeight, int $quality): void
    {
        // Check if file exists
        if (!file_exists($filePath)) {
            throw new \Exception('Image file not found: ' . $filePath);
        }

        // Get image info
        $imageInfo = @getimagesize($filePath);
        if (!$imageInfo) {
            // If getimagesize fails, skip processing
            Log::warning('Could not get image info, skipping processing', [
                'file_path' => $filePath,
            ]);
            return;
        }

        [$width, $height, $type] = $imageInfo;

        // Only process if image exceeds max dimensions
        if ($width <= $maxWidth && $height <= $maxHeight) {
            // Image is already within limits, skip processing
            Log::info('Image already within size limits', [
                'file_path' => $filePath,
                'width' => $width,
                'height' => $height,
            ]);
            return;
        }

        // Create temporary file for processing
        $tempPath = $filePath . '.tmp';

        // Create image resource based on type
        $sourceImage = match ($type) {
            IMAGETYPE_JPEG => @imagecreatefromjpeg($filePath),
            IMAGETYPE_PNG => @imagecreatefrompng($filePath),
            IMAGETYPE_GIF => @imagecreatefromgif($filePath),
            IMAGETYPE_WEBP => function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($filePath) : null,
            default => null,
        };

        if (!$sourceImage) {
            // If image creation fails, skip processing
            Log::warning('Could not create image resource, skipping processing', [
                'file_path' => $filePath,
                'type' => $type,
            ]);
            return;
        }

        // Calculate new dimensions (maintain aspect ratio)
        $ratio = min($maxWidth / $width, $maxHeight / $height, 1);
        $newWidth = (int) ($width * $ratio);
        $newHeight = (int) ($height * $ratio);

        // Create new image
        $newImage = imagecreatetruecolor($newWidth, $newHeight);

        // Preserve transparency for PNG and GIF
        if ($type === IMAGETYPE_PNG || $type === IMAGETYPE_GIF) {
            imagealphablending($newImage, false);
            imagesavealpha($newImage, true);
            $transparent = imagecolorallocatealpha($newImage, 255, 255, 255, 127);
            imagefill($newImage, 0, 0, $transparent);
        } else {
            // Fill background for JPEG
            $white = imagecolorallocate($newImage, 255, 255, 255);
            imagefill($newImage, 0, 0, $white);
        }

        // Resize image
        imagecopyresampled(
            $newImage, $sourceImage,
            0, 0, 0, 0,
            $newWidth, $newHeight, $width, $height
        );

        // Save optimized image to temporary file
        $success = match ($type) {
            IMAGETYPE_JPEG => imagejpeg($newImage, $tempPath, $quality),
            IMAGETYPE_PNG => imagepng($newImage, $tempPath, 9),
            IMAGETYPE_GIF => imagegif($newImage, $tempPath),
            IMAGETYPE_WEBP => function_exists('imagewebp') ? imagewebp($newImage, $tempPath, $quality) : false,
        };

        // Clean up
        imagedestroy($sourceImage);
        imagedestroy($newImage);

        if ($success && file_exists($tempPath)) {
            // Replace original file with processed version
            rename($tempPath, $filePath);
        } else {
            // If saving fails, remove temp file and skip
            if (file_exists($tempPath)) {
                unlink($tempPath);
            }
            Log::warning('Failed to save processed image', [
                'file_path' => $filePath,
            ]);
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('Product image processing job failed after retries', [
            'exception' => $exception,
            'media_id' => $this->mediaId,
        ]);
    }
}

