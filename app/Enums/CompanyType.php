<?php

declare(strict_types=1);

namespace Blumilksoftware\Lmt\Enums;

use Filament\Support\Contracts\HasLabel;

enum CompanyType: string implements HasLabel
{
    case Host = "host";
    case Partner = "partner";
    case Sponsor = "sponsor";
    case Patron = "patron";
    case Division = "division";

    public static function available(): array
    {
        return collect([
            self::Host,
            self::Patron,
            self::Sponsor,
            self::Partner,
        ])
            ->mapWithKeys(fn(CompanyType $type) => [
                $type->value => $type->getLabel(),
            ])
            ->toArray();
    }

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Host => "Organizator",
            self::Partner => "Partner",
            self::Sponsor => "Sponsor",
            self::Patron => "Patronat",
            self::Division => "Podział",
        };
    }

    public function isDivision(): bool
    {
        return $this === CompanyType::Division;
    }
}
