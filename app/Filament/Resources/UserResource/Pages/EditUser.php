<?php

declare(strict_types=1);

namespace Blumilksoftware\Lmt\Filament\Resources\UserResource\Pages;

use Blumilksoftware\Lmt\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
