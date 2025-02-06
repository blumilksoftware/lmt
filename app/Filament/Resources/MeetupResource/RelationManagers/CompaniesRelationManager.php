<?php

declare(strict_types=1);

namespace Blumilksoftware\Lmt\Filament\Resources\MeetupResource\RelationManagers;

use Blumilksoftware\Lmt\Enums\CompanyType;
use Blumilksoftware\Lmt\Models\Company;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class CompaniesRelationManager extends RelationManager
{
    protected static ?string $title = "Wpisy firm";
    protected static string $relationship = "companies";

    public function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Forms\Components\Select::make("type")
                    ->options(CompanyType::available())
                    ->label("Typ")
                    ->default(CompanyType::Sponsor)
                    ->required(),
                Forms\Components\TextInput::make("name")
                    ->label("Nazwa")
                    ->required()
                    ->maxLength(255),
                SpatieMediaLibraryFileUpload::make("logo")
                    ->label("Logo")
                    ->image()
                    ->imageEditor()
                    ->imageEditorAspectRatios(["16:9"])
                    ->collection("logo")
                    ->required(),
                Forms\Components\TextInput::make("url")
                    ->label("Link do strony")
                    ->url()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->reorderable("order_column")
            ->defaultSort("order_column")
            ->pluralModelLabel("Wpisy firm")
            ->modelLabel("Wpis firmy")
            ->columns([
                Tables\Columns\TextColumn::make("name")
                    ->label("Nazwa"),
                Tables\Columns\TextColumn::make("type")
                    ->label("Typ")
                    ->badge()
                    ->color(fn(CompanyType $state): string => match ($state) {
                        CompanyType::Host => "primary",
                        CompanyType::Partner => "info",
                        CompanyType::Sponsor => "success",
                        CompanyType::Patron => "danger",
                        CompanyType::Division => "secondary",
                    }),
                Tables\Columns\TextColumn::make("url")
                    ->label("Url")
                    ->limit(30)
                    ->tooltip(fn(Company $record): ?string => $record->url),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
                Tables\Actions\Action::make("Dodaj podział")
                    ->action(fn(): Company => $this->ownerRecord->companies()->create(["type" => CompanyType::Division])),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->hidden(fn(Company $company): bool => $company->type === CompanyType::Division),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
