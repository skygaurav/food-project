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
 * Mailable for welcoming new users.
 *
 * Sends a welcome email after successful registration.
 *
 * @package App\Mail
 */
class UserWelcomeMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * Create a new message instance.
     *
     * @param  \App\Models\User  $user
     */
    public function __construct(
        public User $user
    ) {}

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Welcome to FOODCITA! 🍽️',
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
            view: 'emails.user-welcome',
            with: [
                'user' => $this->user,
                'loginUrl' => url('/login'),
                'uploadUrl' => url('/upload'),
            ],
        );
    }
}
