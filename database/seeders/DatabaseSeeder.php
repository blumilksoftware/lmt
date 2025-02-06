<?php

declare(strict_types=1);

namespace Database\Seeders;

use Blumilksoftware\Lmt\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            "name" => "Test User",
            "email" => "test@example.com",
        ]);
    }
}
