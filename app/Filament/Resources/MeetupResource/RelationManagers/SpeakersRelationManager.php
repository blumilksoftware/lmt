<?php

declare(strict_types=1);

namespace Blumilksoftware\Lmt\Filament\Resources\MeetupResource\RelationManagers;

use Blumilksoftware\Lmt\Models\Speaker;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class SpeakersRelationManager extends RelationManager
{
    protected static ?string $title = "Wpisy prelegentów";
    protected static string $relationship = "speakers";

    public function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Forms\Components\Tabs::make()
                    ->tabs([
                        Forms\Components\Tabs\Tab::make("Podstawowe")
                            ->schema([
                                Forms\Components\Grid::make()
                                    ->schema([
                                        Forms\Components\TextInput::make("first_name")
                                            ->label("Imię")
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make("last_name")
                                            ->label("Nazwisko")
                                            ->required()
                                            ->maxLength(255),
                                    ]),
                                Forms\Components\Grid::make()
                                    ->schema([
                                        Forms\Components\Textarea::make("description")
                                            ->required()
                                            ->rows(10)
                                            ->label("Opis"),
                                        SpatieMediaLibraryFileUpload::make("photo")
                                            ->label("Zdjęcie")
                                            ->image()
                                            ->imageEditor()
                                            ->imageEditorAspectRatios(["16:9"])
                                            ->collection("photo")
                                            ->conversion("webp")
                                            ->required(),
                                    ]),
                                Forms\Components\Repeater::make("companies")
                                    ->label("Firmy")
                                    ->collapsible()
                                    ->collapsed()
                                    ->itemLabel(fn(array $state): ?string => $state["name"] ?? null)
                                    ->schema([
                                        Forms\Components\TextInput::make("name")
                                            ->label("Nazwa firmy")
                                            ->required(),
                                        Forms\Components\TextInput::make("url")
                                            ->label("Link do strony")
                                            ->url()
                                            ->required()
                                            ->maxLength(255),
                                    ])->columns(),
                            ]),

                        Forms\Components\Tabs\Tab::make("Prezentacja")
                            ->schema([
                                Forms\Components\TextInput::make("presentation")
                                    ->label("Prezentacja"),
                                Forms\Components\TextInput::make("video_url")
                                    ->label("Link do video")
                                    ->url()
                                    ->maxLength(255),
                                SpatieMediaLibraryFileUpload::make("slides")
                                    ->label("Plik z prezentacją")
                                    ->preserveFilenames()
                                    ->previewable(false)
                                    ->acceptedFileTypes(["application/pdf"])
                                    ->collection("slides"),
                            ]),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->reorderable("order_column")
            ->defaultSort("order_column")
            ->pluralModelLabel("Wpisy prelegentów")
            ->modelLabel("Wpis prelegenta")
            ->columns([
                Tables\Columns\TextColumn::make("full_name")
                    ->label("Imię i nazwisko"),
                Tables\Columns\ImageColumn::make("photo")
                    ->label("Zdjęcie")
                    ->getStateUsing(fn(Speaker $record): ?string => $record->photo?->getUrl()),
                Tables\Columns\TextColumn::make("companies")
                    ->label("Firmy")
                    ->getStateUsing(fn(Speaker $record): array => $record->companies->pluck("name")->toArray())
                    ->badge(),
                Tables\Columns\TextColumn::make("presentation")
                    ->label("Prezentacja")
                    ->limit(20)
                    ->tooltip(fn(Speaker $record): ?string => $record->presentation),
                Tables\Columns\TextColumn::make("description")
                    ->label("Opis")
                    ->limit(20)
                    ->tooltip(fn(Speaker $record): ?string => $record->description),
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
