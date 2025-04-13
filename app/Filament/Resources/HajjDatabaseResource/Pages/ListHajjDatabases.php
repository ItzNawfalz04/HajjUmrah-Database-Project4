<?php

namespace App\Filament\Resources\HajjDatabaseResource\Pages;

use App\Filament\Resources\HajjDatabaseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHajjDatabases extends ListRecords
{
    protected static string $resource = HajjDatabaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label(__('hajj_database.create_button_label')), // Custom button label
        ];
    }
}
