<?php

declare(strict_types=1);

namespace Database\Factories;

use Blumilksoftware\Lmt\Enums\CompanyType;
use Blumilksoftware\Lmt\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;
use SplFileInfo;

/**
 * @extends Factory<Company>
 */
class CompanyFactory extends Factory
{
    public function definition(): array
    {
        return [
            "name" => fn(array $attr): ?string => $attr["type"] === CompanyType::Division ? null : fake()->company(),
            "type" => fake()->randomElement(CompanyType::cases()),
            "url" => fn(array $attr): ?string => $attr["type"] === CompanyType::Division ? null : fake()->url(),
        ];
    }

    public function configure(): Factory
    {
        return $this->afterCreating(function (Company $company): void {
            if ($company->type === CompanyType::Division) {
                return;
            }

            $files = File::allFiles(resource_path("data/companies"));

            /** @var SplFileInfo $file */
            $file = collect($files)->random(1)->first();

            $company
                ->addMediaFromString(File::get($file->getPathname()))
                ->usingFileName($file->getFilename())
                ->toMediaCollection("logo");
        });
    }
}
