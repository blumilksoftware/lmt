<?php

declare(strict_types=1);

namespace Database\Factories;

use Blumilksoftware\Lmt\Models\Meetup;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

/**
 * @extends Factory<Meetup>
 */
class MeetupFactory extends Factory
{
    public function definition(): array
    {
        return [
            "title" => fake()->sentence(),
            "slug" => fn(array $attr): string => Str::slug($attr["title"]),
            "place" => fake()->address(),
            "localization" => fake()->url(),
            "fb_event" => fake()->url(),
            "date" => fake()->dateTimeBetween(now()->startOfYear(), now()->endOfYear()),
            "photographers" => fake()->name(),
            "active" => false,
        ];
    }

    public function configure(): Factory
    {
        return $this->afterCreating(function (Meetup $meetup): void {
            $file = File::get(resource_path("data/regulamin-konkursu.pdf"));

            $meetup
                ->addMediaFromString($file)
                ->usingFileName("regulamin-konkursu.pdf")
                ->toMediaCollection("regulations");

            $files = File::allFiles(resource_path("data/gallery"));

            $files = collect($files)->random(12);

            foreach ($files as $file) {
                $meetup
                    ->addMediaFromString(File::get($file->getPathname()))
                    ->usingFileName($file->getFilename())
                    ->toMediaCollection("photos");
            }
        });
    }
}
