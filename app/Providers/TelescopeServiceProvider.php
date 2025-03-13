<?php

declare(strict_types=1);

namespace Blumilksoftware\Lmt\Providers;

use Illuminate\Support\Facades\Gate;
use Laravel\Telescope\IncomingEntry;
use Laravel\Telescope\Telescope;
use Laravel\Telescope\TelescopeApplicationServiceProvider;

class TelescopeServiceProvider extends TelescopeApplicationServiceProvider
{
    public function register(): void
    {
        $this->hideSensitiveRequestDetails();

        $isLocal = $this->app->environment("local");

        Telescope::filter(fn(IncomingEntry $entry) => $isLocal ||
                   $entry->isReportableException() ||
                   $entry->isFailedRequest() ||
                   $entry->isFailedJob() ||
                   $entry->isScheduledTask() ||
                   $entry->hasMonitoredTag());
    }

    protected function hideSensitiveRequestDetails(): void
    {
        if ($this->app->environment("local")) {
            return;
        }

        Telescope::hideRequestParameters(["_token"]);

        Telescope::hideRequestHeaders([
            "cookie",
            "x-csrf-token",
            "x-xsrf-token",
        ]);
    }

    protected function gate(): void
    {
        Gate::define("viewTelescope", fn($user) => in_array($user->email, [], true));
    }
}
