<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserPasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user,
        public string $token
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reset Your Password - FOODCITA',
        );
    }

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
