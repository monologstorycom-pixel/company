<?php

namespace App\Services;

use App\Repositories\ContactRepository;
use App\Mail\ContactNotification;
use App\Jobs\SendContactNotification;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactService
{
    /**
     * Admin email for contact notifications.
     */
    const ADMIN_EMAIL = 'admin@example.com'; // Should be configurable via settings

    public function __construct(
        protected ContactRepository $repository
    ) {}

    /**
     * Create a new contact submission (with email notification via queue).
     *
     * @param array $data
     * @param string|null $ipAddress
     * @param string|null $userAgent
     * @return \App\Models\Contact
     */
    public function create(array $data, ?string $ipAddress = null, ?string $userAgent = null)
    {
        return DB::transaction(function () use ($data, $ipAddress, $userAgent) {
            // Check rate limit (max 5 submissions per minute per IP)
            $key = 'contact_form:' . ($ipAddress ?? 'unknown');
            
            if (RateLimiter::tooManyAttempts($key, 5)) {
                throw new \Exception('Too many submission attempts. Please try again later.');
            }

            RateLimiter::hit($key, 60); // 60 seconds

            // Add IP address and user agent
            $data['ip_address'] = $ipAddress;
            $data['user_agent'] = $userAgent;

            // Create contact
            $contact = $this->repository->create($data);

            // Send email notification via queue
            try {
                // Get admin email from settings or config
                $recipientEmail = $this->getAdminEmail();
                
                if ($recipientEmail) {
                    // Use job for email sending (queued for better control)
                    SendContactNotification::dispatch($contact, $recipientEmail)
                        ->onQueue('emails');
                }
            } catch (\Exception $e) {
                // Log error but don't fail the contact creation
                Log::error('Failed to queue contact notification email: ' . $e->getMessage(), [
                    'exception' => $e,
                    'contact_id' => $contact->id,
                ]);
            }

            return $contact;
        });
    }

    /**
     * Mark contact as read.
     *
     * @param int $id
     * @return bool
     */
    public function markAsRead(int $id): bool
    {
        return $this->repository->markAsRead($id);
    }

    /**
     * Mark contact as replied.
     *
     * @param int $id
     * @return bool
     */
    public function markAsReplied(int $id): bool
    {
        return $this->repository->markAsReplied($id);
    }

    /**
     * Get unread contacts.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUnreadContacts()
    {
        return $this->repository->getUnreadContacts();
    }

    /**
     * Get admin email from settings or config.
     *
     * @return string|null
     */
    protected function getAdminEmail(): ?string
    {
        // Try to get from settings
        try {
            $adminEmail = \App\Models\Setting::where('key', 'admin_email')->value('value');
            if ($adminEmail) {
                return $adminEmail;
            }
        } catch (\Exception $e) {
            // Settings table might not exist or have this key
        }

        // Fallback to config
        return config('mail.admin_email') ?? config('mail.from.address');
    }
}

