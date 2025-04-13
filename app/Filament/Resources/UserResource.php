<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    public static function getNavigationGroup(): ?string
    {
        return __('user.navigation_group');
    }

    public static function getModelLabel(): string
    {
        return __('user.model_label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('user.plural_model_label');
    }


    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function getNavigationBadge(): ?string
    {
        return User::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('user.name'))
                    ->required(),
                Forms\Components\TextInput::make('email')
                    ->label(__('user.email'))
                    ->email()
                    ->required(),
                Forms\Components\Select::make('roles')
                    ->label(__('user.roles'))
                    ->relationship('roles', 'name')
                    ->native(false)
                    ->preload(),
                Forms\Components\TextInput::make('password')
                    ->label(__('user.password'))
                    ->password()
                    ->revealable()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                ->label(__('user.name'))
                ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label(__('user.email'))
                    ->searchable(),
                Tables\Columns\TagsColumn::make('roles.name')
                    ->label(__('user.roles'))
                    ->separator(', ')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('user.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('user.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
