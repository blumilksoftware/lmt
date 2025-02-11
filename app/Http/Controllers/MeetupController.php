<?php

declare(strict_types=1);

namespace Blumilksoftware\Lmt\Http\Controllers;

use Blumilksoftware\Lmt\Models\Meetup;
use Illuminate\View\View;

class MeetupController extends Controller
{
    public function __invoke(string $meetup): View
    {
        $meetup = Meetup::query()
            ->where("slug", $meetup)
            ->active()
            ->firstOrFail();

        $previousMeetups = $meetup->isCurrent()
            ? Meetup::query()
                ->active()
                ->whereNot("id", $meetup->id)
                ->orderByDesc("date")
                ->get()
            : collect();

        return view("meetup", [
            "meetup" => $meetup,
            "previousMeetups" => $previousMeetups,
        ]);
    }
}
