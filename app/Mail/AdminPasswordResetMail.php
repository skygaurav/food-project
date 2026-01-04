<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\Admin;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Mailable for admin password reset emails.
 *
 * Sends a password reset link to admin users.
 *
 * @package App\Mail
 */
class AdminPasswordResetMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * Create a new message instance.
     *
     * @param  \App\Models\Admin  $admin
     * @param  string  $token
     */
    public function __construct(
        public Admin $admin,
        public string $token
    ) {}

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reset Your Admin Password - FOODCITA',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.admin-password-reset',
            with: [
                'admin' => $this->admin,
                'resetUrl' => url('/admin/reset-password/' . $this->token . '?email=' . urlencode($this->admin->email)),
            ],
        );
    }
}
