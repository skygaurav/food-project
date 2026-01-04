<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\Dish;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Mailable for notifying admin of new dish submissions.
 *
 * Sends notification to admin when a new dish is submitted for review.
 *
 * @package App\Mail
 */
class NewDishSubmittedAdminMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * Create a new message instance.
     *
     * @param  \App\Models\Dish  $dish
     */
    public function __construct(
        public Dish $dish
    ) {}

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Dish Submitted for Review - FOODCITA Admin',
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
            view: 'emails.admin-new-dish',
            with: [
                'dish' => $this->dish,
                'adminUrl' => url('/admin/dishes/' . $this->dish->id),
            ],
        );
    }
}
