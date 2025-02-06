<?php

declare(strict_types=1);

namespace Database\Factories;

use Blumilksoftware\Lmt\Models\Meetup;
use Blumilksoftware\Lmt\Models\Speaker;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;
use SplFileInfo;

/**
 * @extends Factory<Speaker>
 */
class SpeakerFactory extends Factory
{
    public function definition(): array
    {
        return [
            "first_name" => fake()->firstName(),
            "last_name" => fake()->lastName(),
            "meetup_id" => Meetup::factory(),
            "description" => fake()->text(),
            "presentation" => fake()->sentence,
            "companies" => [
                ["name" => fake()->company(), "url" => fake()->url()],
                ["name" => fake()->company(), "url" => fake()->url()],
            ],
            "video_url" => fake()->optional(20)->url(),
        ];
    }

    public function configure(): Factory
    {
        return $this->afterCreating(function (Speaker $speaker): void {
            $files = File::allFiles(resource_path("data/speakers"));

            /** @var SplFileInfo $file */
            $file = collect($files)->random(1)->first();

            $speaker
                ->addMediaFromString(File::get($file->getPathname()))
                ->usingFileName($file->getFilename())
                ->toMediaCollection("photo");

            if (!$speaker->video_url) {
                return;
            }

            $files = File::allFiles(resource_path("data/presentations"));

            /** @var SplFileInfo $file */
            $file = collect($files)->random(1)->first();

            $speaker
                ->addMediaFromString(File::get($file->getPathname()))
                ->usingFileName($file->getFilename())
                ->toMediaCollection("slides");
        });
    }
}
