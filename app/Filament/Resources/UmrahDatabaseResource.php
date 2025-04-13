<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UmrahDatabaseResource\Pages;
use App\Filament\Resources\UmrahDatabaseResource\RelationManagers;
use App\Models\UmrahDatabase;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UmrahParticipantResource\Pages\CreateUmrahParticipant;
use App\Filament\Resources\UmrahParticipantResource\Pages\EditUmrahParticipant;
use App\Filament\Resources\UmrahParticipantResource\Pages\ListUmrahParticipants;
use Filament\Facades\Filament;
use Filament\Tables\Actions\Action;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Support\Facades\Lang;

class UmrahDatabaseResource extends Resource
{
    protected static ?string $model = UmrahDatabase::class;

    public static function getNavigationLabel(): string
    {
        return __('umrah_database.navigation_label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('umrah_database.navigation_group');
    }

    public static function getModelLabel(): string
    {
        return __('umrah_database.model_label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('umrah_database.plural_model_label');
    }

    protected static ?string $navigationIcon = 'heroicon-o-circle-stack';

    public static function getNavigationBadge(): ?string
    {
        return UmrahDatabase::count();
    }

    public static function getRecordTitle(?Model $record): string|null|Htmlable
    {
        return $record->name;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('umrah_database.name'))
                    ->required(),
                Forms\Components\TextInput::make('code')
                    ->label(__('umrah_database.code'))
                    ->required(),
                Forms\Components\Textarea::make('description')
                    ->label(__('umrah_database.description'))
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Stack::make([
                    TextColumn::make('name')
                        ->weight(FontWeight::Bold)
                        ->searchable()
                        ->sortable()
                        ->icon('heroicon-m-folder') // Adding the folder icon
                        ->size('xxl') // Making the icon larger
                        ->iconColor('primary'),
                    TextColumn::make('code')
                        ->searchable()
                        //->icon('heroicon-m-tag') // Adding an icon
                        ->size('sm') // Making the text smaller
                        ->weight(FontWeight::Light), // Making it visually lighter
                ]),
                
                Panel::make([
                    Split::make([
                        TextColumn::make('created_at')
                            ->label(__('umrah_database.created_at'))
                            ->date()
                            ->sortable()
                            ->icon('heroicon-m-calendar-days'),
                        TextColumn::make('updated_at')
                            ->label(__('umrah_database.updated_at'))
                            ->dateTime()
                            ->sortable()
                            ->icon('heroicon-m-arrow-path'),
                    ]),
                    TextColumn::make('description')
                        ->wrap()
                        ->markdown()
                        ->limit(150)
                        ->icon('heroicon-m-document-text'), // Limit text to 150 characters before expanding
                ])
                ->collapsible(), // Makes the panel collapsible
            ])
            ->contentGrid([
                'md' => 2, // 2 columns on medium screens
                'xl' => 2, // 2 columns on extra-large screens
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Action::make(__('umrah_database.list_participants'))
                    ->color('success')
                    ->icon('heroicon-m-user-group')
                    ->url(
                        fn (UmrahDatabase $record): string => static::getUrl('umrah-participants.index', [
                            'parent' => $record->id,
                        ])
                    ),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->recordUrl(
                fn (UmrahDatabase $record): string => static::getUrl('umrah-participants.index', [
                    'parent' => $record->id,
                ])
            );
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUmrahDatabases::route('/'),
            'create' => Pages\CreateUmrahDatabase::route('/create'),
            'edit' => Pages\EditUmrahDatabase::route('/{record}/edit'),

            // Participant management
            'umrah-participants.index' => ListUmrahParticipants::route('/{parent}/umrah-participants'),
            'umrah-participants.create' => CreateUmrahParticipant::route('/{parent}/umrah-participants/create'),
            'umrah-participants.edit' => EditUmrahParticipant::route('/{parent}/umrah-participants/{record}/edit'),
        ];
    }
}
