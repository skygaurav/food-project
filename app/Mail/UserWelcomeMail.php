<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserWelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Welcome to FOODCITA! 🍽️',
        );
    }

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
