<?php

declare(strict_types=1);

namespace Database\Factories;

use Blumilksoftware\Lmt\Models\Agenda;
use Blumilksoftware\Lmt\Models\Meetup;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Agenda>
 */
class AgendaFactory extends Factory
{
    public function definition(): array
    {
        return [
            "title" => fake()->sentence(),
            "speaker" => fake()->name() . ", " . fake()->company(),
            "description" => fake()->optional(30)->text(),
            "meetup_id" => Meetup::factory(),
            "start" => fake()->time("H:i"),
        ];
    }
}
