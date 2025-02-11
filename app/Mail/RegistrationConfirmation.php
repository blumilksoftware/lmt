<?php

declare(strict_types=1);

namespace Blumilksoftware\Lmt\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RegistrationConfirmation extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        protected array $data,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "LMT - Potwierdzenie rejestracji",
        );
    }

    public function content(): Content
    {
        return new Content(view: "mail.registration_confirmation", with: [
            "name" => $this->data["name"],
            "date" => $this->data["date"],
            "place" => $this->data["place"],
            "fb_event" => $this->data["fb_event"],
        ]);
    }
}
