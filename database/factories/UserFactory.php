<?php

declare(strict_types=1);

namespace Database\Factories;

use Blumilksoftware\Lmt\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            "name" => fake()->name(),
            "email" => fake()->unique()->safeEmail(),
            "password" => static::$password ??= Hash::make("password"),
            "remember_token" => Str::random(10),
        ];
    }
}
