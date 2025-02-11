<?php

declare(strict_types=1);

namespace Blumilksoftware\Lmt\Filament\Resources\MeetupResource\Pages;

use Blumilksoftware\Lmt\Filament\Resources\MeetupResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMeetups extends ListRecords
{
    protected static string $resource = MeetupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
