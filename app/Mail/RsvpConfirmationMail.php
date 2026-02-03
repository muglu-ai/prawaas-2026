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
        $eventName = config('constants.EVENT_NAME', 'Event');
        $eventYear = config('constants.EVENT_YEAR', date('Y'));

        return new Envelope(
            subject: "RSVP Confirmation - {$eventName} {$eventYear}",
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
