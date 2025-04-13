<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HajjDatabaseResource\Pages;
use App\Filament\Resources\HajjDatabaseResource\RelationManagers;
use App\Models\HajjDatabase;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\HajjParticipantResource\Pages\CreateHajjParticipant;
use App\Filament\Resources\HajjParticipantResource\Pages\EditHajjParticipant;
use App\Filament\Resources\HajjParticipantResource\Pages\ListHajjParticipants;
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

class HajjDatabaseResource extends Resource
{
    protected static ?string $model = HajjDatabase::class;

    public static function getNavigationLabel(): string
    {
        return __('hajj_database.navigation_label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('hajj_database.navigation_group');
    }

    public static function getModelLabel(): string
    {
        return __('hajj_database.model_label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('hajj_database.plural_model_label');
    }


    protected static ?string $navigationIcon = 'heroicon-o-circle-stack';

    public static function getNavigationBadge(): ?string
    {
        return HajjDatabase::count();
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
                    ->label(__('hajj_database.name'))
                    ->required(),
                Forms\Components\TextInput::make('code')
                    ->label(__('hajj_database.code'))
                    ->required(),
                Forms\Components\Textarea::make('description')
                    ->label(__('hajj_database.description'))
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
                            ->label(__('hajj_database.created_at'))
                            ->date()
                            ->sortable()
                            ->icon('heroicon-m-calendar-days'),
                        TextColumn::make('updated_at')
                            ->label(__('hajj_database.updated_at'))
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
                Action::make(__('hajj_database.view_participants'))
                    ->color('success')
                    ->icon('heroicon-m-user-group')
                    ->url(
                        fn (HajjDatabase $record): string => static::getUrl('hajj-participants.index', [
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
                fn (HajjDatabase $record): string => static::getUrl('hajj-participants.index', [
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
            'index' => Pages\ListHajjDatabases::route('/'),
            'create' => Pages\CreateHajjDatabase::route('/create'),
            'edit' => Pages\EditHajjDatabase::route('/{record}/edit'),

            // Participant management
            'hajj-participants.index' => ListHajjParticipants::route('/{parent}/hajj-participants'),
            'hajj-participants.create' => CreateHajjParticipant::route('/{parent}/hajj-participants/create'),
            'hajj-participants.edit' => EditHajjParticipant::route('/{parent}/hajj-participants/{record}/edit'),
        ];
    }
}
