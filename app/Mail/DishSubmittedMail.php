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

class DishSubmittedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Dish $dish,
        public User $user
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Dish Has Been Submitted for Review - FOODCITA',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.dish-submitted',
            with: [
                'dish' => $this->dish,
                'user' => $this->user,
                'myDishesUrl' => url('/my-dishes'),
            ],
        );
    }
}
