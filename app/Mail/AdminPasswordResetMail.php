<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\Admin;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminPasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Admin $admin,
        public string $token
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reset Your Admin Password - FOODCITA',
        );
    }

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
