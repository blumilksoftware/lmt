<?php

declare(strict_types=1);

namespace Database\Seeders;

use Blumilksoftware\Lmt\Models\Meetup;
use Blumilksoftware\Lmt\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            "name" => "Test User",
            "email" => "admin@example.com",
        ]);

        Meetup::factory()
            ->count(10)
            ->hasAgendas(8)
            ->hasSpeakers(3)
            ->hasCompanies(8)
            ->create();

        Meetup::query()->first()->update(["active" => true]);
    }
}
