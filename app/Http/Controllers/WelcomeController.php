<?php

declare(strict_types=1);

namespace Blumilksoftware\Lmt\Http\Controllers;

use Blumilksoftware\Lmt\Models\Meetup;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class WelcomeController extends Controller
{
    public function __invoke(): View|RedirectResponse
    {
        $meetup = Meetup::query()
            ->current()
            ->active()
            ->first();

        if ($meetup) {
            return redirect()->route("meetups.show", ["meetup" => $meetup->slug]);
        }

        $previousMeetups = Meetup::query()
            ->active()
            ->orderByDesc("date")
            ->get();

        return view("welcome", [
            "previousMeetups" => $previousMeetups,
        ]);
    }
}
