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

/**
 * Mailable for dish rejection notification.
 *
 * Notifies the user that their submitted dish has been rejected.
 *
 * @package App\Mail
 */
class DishRejectedMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * Create a new message instance.
     *
     * @param  \App\Models\Dish  $dish
     * @param  \App\Models\User  $user
     */
    public function __construct(
        public Dish $dish,
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
            subject: 'Update on Your Dish Submission - FOODCITA',
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
            view: 'emails.dish-rejected',
            with: [
                'dish' => $this->dish,
                'user' => $this->user,
                'myDishesUrl' => url('/my-dishes'),
            ],
        );
    }
}
