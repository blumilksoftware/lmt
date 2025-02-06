<?php

declare(strict_types=1);

namespace Blumilksoftware\Lmt\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SomeoneRegistered extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        protected array $data,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "LMT - nowa rejestracja",
        );
    }

    public function content(): Content
    {
        return new Content(view: "mail.registration_notice", with: [
            "name" => $this->data["name"] ?? "-",
            "surname" => $this->data["surname"] ?? "-",
            "email" => $this->data["email"] ?? "-",
            "company" => $this->data["company"] ?? "-",
            "date" => $this->data["date"] ?? "-",
        ]);
    }
}
