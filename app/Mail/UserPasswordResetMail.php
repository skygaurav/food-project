<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Mailable for user password reset emails.
 *
 * Sends a password reset link to frontend users.
 *
 * @package App\Mail
 */
class UserPasswordResetMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * Create a new message instance.
     *
     * @param  \App\Models\User  $user
     * @param  string  $token
     */
    public function __construct(
        public User $user,
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
            subject: 'Reset Your Password - FOODCITA',
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
            view: 'emails.user-password-reset',
            with: [
                'user' => $this->user,
                'resetUrl' => url('/reset-password/' . $this->token . '?email=' . urlencode($this->user->email)),
            ],
        );
    }
}
