<?php

declare(strict_types=1);

namespace Blumilksoftware\Lmt\Providers;

use Blumilksoftware\Lmt\Models\Meetup;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use Laravel\Telescope\TelescopeServiceProvider as LaravelTelescopeServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        if ($this->app->environment("local")) {
            $this->app->register(LaravelTelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    public function boot(): void
    {
        Relation::morphMap([
            "meetup" => Meetup::class,
        ]);
    }
}
