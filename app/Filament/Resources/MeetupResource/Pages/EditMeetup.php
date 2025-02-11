<?php

declare(strict_types=1);

namespace Blumilksoftware\Lmt\Filament\Resources\MeetupResource\Pages;

use Blumilksoftware\Lmt\Filament\Resources\MeetupResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMeetup extends EditRecord
{
    protected static string $resource = MeetupResource::class;

    public function getContentTabLabel(): ?string
    {
        return "Wydarzenie";
    }

    public function hasCombinedRelationManagerTabsWithContent(): bool
    {
        return true;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
