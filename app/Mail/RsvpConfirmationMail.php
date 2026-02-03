<?php

namespace App\Mail;

use App\Models\Rsvp;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RsvpConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public Rsvp $rsvp;

    public function __construct(Rsvp $rsvp)
    {
        $this->rsvp = $rsvp;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "RSVP Confirmation - Prawaas 5.0 Curtain Raiser",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.rsvp.confirmation',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
