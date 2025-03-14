<?php

declare(strict_types=1);

namespace Blumilksoftware\Lmt\Filament\Resources;

use Blumilksoftware\Lmt\Filament\Resources\MeetupResource\Pages;
use Blumilksoftware\Lmt\Filament\Resources\MeetupResource\RelationManagers\AgendasRelationManager;
use Blumilksoftware\Lmt\Filament\Resources\MeetupResource\RelationManagers\CompaniesRelationManager;
use Blumilksoftware\Lmt\Filament\Resources\MeetupResource\RelationManagers\SpeakersRelationManager;
use Blumilksoftware\Lmt\Models\Meetup;
use Filament\Forms\Components;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class MeetupResource extends Resource
{
    protected static ?string $model = Meetup::class;
    protected static ?string $pluralLabel = "Wydarzenia";
    protected static ?string $modelLabel = "Wydarzenie";
    protected static ?string $navigationIcon = "heroicon-o-rectangle-stack";

    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Components\Tabs::make()->tabs([
                    Components\Tabs\Tab::make("Dane podstawowe")
                        ->schema([
                            Components\TextInput::make("title")
                                ->label("Tytuł")
                                ->maxLength(255)
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn(Set $set, ?string $state) => $set("slug", Str::slug($state)))
                                ->required(),
                            Components\TextInput::make("slug")
                                ->label("Slug")
                                ->maxLength(255)
                                ->regex("/^[a-z0-9]+(?:-[a-z0-9]+)*$/")
                                ->unique("meetups", "slug", ignoreRecord: true)
                                ->required(),
                            Components\TextInput::make("place")
                                ->label("Miejsce")
                                ->maxLength(255)
                                ->required(),
                            Components\TextInput::make("localization")
                                ->label("Lokalizacja (link)")
                                ->maxLength(255)
                                ->url()
                                ->required(),
                            Components\TextInput::make("fb_event")
                                ->label("Wydarzenie na FB (link)")
                                ->maxLength(255)
                                ->url()
                                ->required(),
                            Components\DateTimePicker::make("date")
                                ->label("Data")
                                ->seconds(false)
                                ->native(false)
                                ->displayFormat("d.m.Y H:i")
                                ->format("Y-m-d H:i")
                                ->required(),

                            SpatieMediaLibraryFileUpload::make("regulations")
                                ->label("Regulamin")
                                ->preserveFilenames()
                                ->acceptedFileTypes(["application/pdf"])
                                ->collection("regulations"),
                        ]),
                    Components\Tabs\Tab::make("Galeria")
                        ->schema([
                            Components\TextInput::make("photographers")
                                ->label("Autorzy zdjęć")
                                ->maxLength(255),
                            SpatieMediaLibraryFileUpload::make("photos")
                                ->multiple()
                                ->maxFiles(12)
                                ->reorderable()
                                ->appendFiles()
                                ->label("Galeria")
                                ->image()
                                ->imageEditor()
                                ->imageEditorAspectRatios(["16:9"])
                                ->conversion("webp")
                                ->collection("photos"),
                        ]),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort("created_at", "desc")
            ->columns([
                Tables\Columns\TextColumn::make("title")
                    ->label("Tytuł")
                    ->limit(40)
                    ->searchable(),
                Tables\Columns\TextColumn::make("place")
                    ->label("Miejsce")
                    ->searchable(),
                Tables\Columns\TextColumn::make("date")
                    ->label("Data")
                    ->dateTime(),
                Tables\Columns\ToggleColumn::make("active")
                    ->label("Widoczne"),
                Tables\Columns\TextColumn::make("created_at")
                    ->label("Data utworzenia")
                    ->getStateUsing(fn(Meetup $record): string => $record->created_at->diffForHumans()),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            CompaniesRelationManager::class,
            SpeakersRelationManager::class,
            AgendasRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            "index" => Pages\ListMeetups::route("/"),
            "create" => Pages\CreateMeetup::route("/create"),
            "edit" => Pages\EditMeetup::route("/{record}/edit"),
        ];
    }
}
