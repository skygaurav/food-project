<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\Dish;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewDishSubmittedAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Dish $dish
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Dish Submitted for Review - FOODCITA Admin',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.admin-new-dish',
            with: [
                'dish' => $this->dish,
                'adminUrl' => url('/admin/dishes/' . $this->dish->id),
            ],
        );
    }
}
