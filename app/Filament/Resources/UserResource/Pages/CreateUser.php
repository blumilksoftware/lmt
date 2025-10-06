<?php

declare(strict_types=1);

namespace Blumilksoftware\Lmt\Filament\Resources\UserResource\Pages;

use Blumilksoftware\Lmt\Filament\Resources\UserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
}
