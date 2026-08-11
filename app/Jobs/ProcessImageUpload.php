<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProcessImageUpload implements ShouldQueue
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
        protected string $imagePath,
        protected string $destinationPath,
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
            // Get image processing options
            $maxWidth = $this->options['max_width'] ?? 1920;
            $maxHeight = $this->options['max_height'] ?? 1080;
            $quality = $this->options['quality'] ?? 85;

            // Check if GD library is available for image processing
            if (extension_loaded('gd')) {
                $this->processWithGD($maxWidth, $maxHeight, $quality);
            } else {
                // If GD is not available, just copy the file
                $this->copyImage();
            }

            Log::info('Image processed successfully', [
                'source_path' => $this->imagePath,
                'destination_path' => $this->destinationPath,
            ]);

        } catch (\Exception $e) {
            Log::error('Image processing failed: ' . $e->getMessage(), [
                'exception' => $e,
                'source_path' => $this->imagePath,
                'destination_path' => $this->destinationPath,
            ]);

            // Re-throw exception to trigger retry
            throw $e;
        }
    }

    /**
     * Process image using GD library.
     */
    protected function processWithGD(int $maxWidth, int $maxHeight, int $quality): void
    {
        // Get full paths
        $sourcePath = storage_path('app/public/' . $this->imagePath);
        $destinationPath = storage_path('app/public/' . $this->destinationPath);

        // Check if source file exists
        if (!file_exists($sourcePath)) {
            throw new \Exception('Source image file not found: ' . $this->imagePath);
        }

        // Ensure destination directory exists
        $destinationDir = dirname($destinationPath);
        if (!is_dir($destinationDir)) {
            mkdir($destinationDir, 0755, true);
        }

        // Get image info
        $imageInfo = @getimagesize($sourcePath);
        if (!$imageInfo) {
            // If getimagesize fails, just copy the file
            copy($sourcePath, $destinationPath);
            return;
        }

        [$width, $height, $type] = $imageInfo;

        // Only process if image exceeds max dimensions
        if ($width <= $maxWidth && $height <= $maxHeight) {
            // Image is already within limits, just copy it
            copy($sourcePath, $destinationPath);
            return;
        }

        // Create image resource based on type
        $sourceImage = match ($type) {
            IMAGETYPE_JPEG => @imagecreatefromjpeg($sourcePath),
            IMAGETYPE_PNG => @imagecreatefrompng($sourcePath),
            IMAGETYPE_GIF => @imagecreatefromgif($sourcePath),
            IMAGETYPE_WEBP => function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($sourcePath) : null,
            default => null,
        };

        if (!$sourceImage) {
            // If image creation fails, just copy the file
            copy($sourcePath, $destinationPath);
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

        // Save optimized image
        $success = match ($type) {
            IMAGETYPE_JPEG => imagejpeg($newImage, $destinationPath, $quality),
            IMAGETYPE_PNG => imagepng($newImage, $destinationPath, 9),
            IMAGETYPE_GIF => imagegif($newImage, $destinationPath),
            IMAGETYPE_WEBP => function_exists('imagewebp') ? imagewebp($newImage, $destinationPath, $quality) : false,
        };

        // Clean up
        imagedestroy($sourceImage);
        imagedestroy($newImage);

        if (!$success) {
            // If saving fails, copy original
            copy($sourcePath, $destinationPath);
        }
    }

    /**
     * Copy image without processing.
     */
    protected function copyImage(): void
    {
        $sourcePath = storage_path('app/public/' . $this->imagePath);
        $destinationPath = storage_path('app/public/' . $this->destinationPath);

        // Ensure destination directory exists
        $destinationDir = dirname($destinationPath);
        if (!is_dir($destinationDir)) {
            mkdir($destinationDir, 0755, true);
        }

        copy($sourcePath, $destinationPath);
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('Image processing job failed after retries', [
            'exception' => $exception,
            'source_path' => $this->imagePath,
            'destination_path' => $this->destinationPath,
        ]);
    }
}

