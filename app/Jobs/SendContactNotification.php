<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\ContactNotification;
use App\Models\Contact;

class SendContactNotification implements ShouldQueue
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
        protected Contact $contact,
        protected string $recipientEmail
    ) {
        // Set queue connection
        $this->onQueue('emails');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            // Send email notification
            Mail::to($this->recipientEmail)->send(new ContactNotification($this->contact));

            Log::info('Contact notification email sent', [
                'contact_id' => $this->contact->id,
                'recipient' => $this->recipientEmail,
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to send contact notification email: ' . $e->getMessage(), [
                'exception' => $e,
                'contact_id' => $this->contact->id,
                'recipient' => $this->recipientEmail,
            ]);

            // Re-throw exception to trigger retry
            throw $e;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('Contact notification job failed after retries', [
            'exception' => $exception,
            'contact_id' => $this->contact->id,
            'recipient' => $this->recipientEmail,
        ]);
    }
}


