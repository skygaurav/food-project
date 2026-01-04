<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\Dish;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DishApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Dish $dish,
        public User $user
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Great News! Your Dish Has Been Approved 🎉 - FOODCITA',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.dish-approved',
            with: [
                'dish' => $this->dish,
                'user' => $this->user,
                'dishUrl' => url('/dishes/' . $this->dish->slug),
            ],
        );
    }
}
