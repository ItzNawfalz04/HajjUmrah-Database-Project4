<?php

namespace App\Filament\Resources\UmrahDatabaseResource\Pages;

use App\Filament\Resources\UmrahDatabaseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUmrahDatabases extends ListRecords
{
    protected static string $resource = UmrahDatabaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label(__('umrah_database.create_button_label')), // Custom button label
        ];
    }
}
