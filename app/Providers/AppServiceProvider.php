<?php

declare(strict_types=1);

namespace Blumilksoftware\Lmt\Providers;

use Blumilksoftware\Lmt\Models\Meetup;
use Exception;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use Laravel\Telescope\TelescopeServiceProvider as LaravelTelescopeServiceProvider;
use Lunaweb\RecaptchaV3\Facades\RecaptchaV3;

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

        $this->app["validator"]->extend("recaptchav3", function ($attribute, $value, $parameters): bool {
            $action = $parameters[0];
            $minScore = isset($parameters[1]) ? (float)$parameters[1] : 0.5;

            try {
                $score = RecaptchaV3::verify($value, $action);

                return $score && $score >= $minScore;
            } catch (Exception) {
                return false;
            }
        });
    }
}
