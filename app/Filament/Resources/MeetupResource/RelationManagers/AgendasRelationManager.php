<?php

declare(strict_types=1);

namespace Blumilksoftware\Lmt\Filament\Resources\MeetupResource\RelationManagers;

use Blumilksoftware\Lmt\Models\Agenda;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class AgendasRelationManager extends RelationManager
{
    protected static ?string $title = "Wpisy Agendy";
    protected static string $relationship = "agendas";

    public function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Forms\Components\TextInput::make("start")
                    ->label("Start")
                    ->required(),
                Forms\Components\TextInput::make("speaker")
                    ->label("Prelegent")
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make("title")
                    ->label("Tytuł")
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make("description")
                    ->label("Opis"),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->reorderable("order_column")
            ->defaultSort("order_column")
            ->pluralModelLabel("Wpisy Agendy")
            ->modelLabel("Wpis agendy")
            ->columns([
                Tables\Columns\TextColumn::make("start")
                    ->label("Start"),
                Tables\Columns\TextColumn::make("title")
                    ->label("Tytuł")
                    ->limit(30)
                    ->tooltip(fn(Agenda $record): ?string => $record->title),
                Tables\Columns\TextColumn::make("speaker")
                    ->label("Prelegent"),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
