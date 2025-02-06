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
    public ?string $email;
    public ?string $name;
    public ?string $surname;
    public ?string $company;
    public bool $consent = false;
    public bool $success = false;

    public function rules(): array
    {
        return [
            "email" => ["required", "email"],
            "name" => ["required", "min:2", "max:50"],
            "surname" => ["required", "min:2", "max:50"],
            "company" => ["max:50"],
            "consent" => ["required", "accepted"],
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

        /** @var Meetup $meetup */
        $meetup = Meetup::query()->active()->current()->firstOrFail();

        Mail::to($this->email)->send(new RegistrationConfirmation([
            "name" => $this->name,
            "date" => $meetup->date->translatedFormat("d F Y, H:i"),
            "place" => $meetup->place,
            "fb_event" => $meetup->fb_event,
        ]));

        Mail::to(config("services.notification_email"))
            ->send(new SomeoneRegistered([
                "email" => $this->email,
                "name" => $this->name,
                "surname" => $this->surname,
                "company" => $this->company,
                "consent" => $this->consent,
                "date" => now()->toDateTimeString(),
            ]));

        $this->success = true;

        $this->reset(["email", "name", "surname", "company", "consent"]);
    }
}
