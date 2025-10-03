<?php

declare(strict_types=1);

namespace Blumilksoftware\Lmt\Livewire;

use Blumilksoftware\Lmt\Mail\RegistrationConfirmation;
use Blumilksoftware\Lmt\Mail\SomeoneRegistered;
use Blumilksoftware\Lmt\Models\Meetup;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class ContactForm extends Component
{
    public Meetup $meetup;
    public ?string $recaptcha;
    public ?string $email;
    public ?string $name;
    public ?string $surname;
    public ?string $company = null;
    public bool $consent = false;
    public bool $success = false;

    public function mount(Meetup $meetup): void
    {
        $this->meetup = $meetup;
    }

    public function rules(): array
    {
        return [
            "email" => ["required", "email"],
            "name" => ["required", "min:2", "max:50"],
            "surname" => ["required", "min:2", "max:50"],
            "company" => ["max:50"],
            "consent" => ["required", "accepted"],
            "recaptcha" => ["required", "recaptchav3:contact,0.5"],
        ];
    }

    public function render(): View
    {
        return view("livewire.contact-form", [
            "errors" => $this->getErrorBag(),
        ]);
    }

    public function submit(): void
    {
        $this->validate();

        Mail::to($this->email)->send(new RegistrationConfirmation([
            "name" => $this->name,
            "date" => $this->meetup->date->translatedFormat("d F Y, H:i"),
            "place" => $this->meetup->place,
            "fb_event" => $this->meetup->fb_event,
        ]));

        Mail::to(config("services.notification_email"))
            ->send(new SomeoneRegistered([
                "email" => $this->email,
                "name" => $this->name,
                "surname" => $this->surname,
                "company" => $this->company,
                "consent" => $this->consent,
                "meetup" => route("meetups.show", $this->meetup->slug),
                "date" => now()->toDateTimeString(),
            ]));

        $this->success = true;

        $this->reset(["email", "name", "surname", "company", "consent"]);
    }
}
