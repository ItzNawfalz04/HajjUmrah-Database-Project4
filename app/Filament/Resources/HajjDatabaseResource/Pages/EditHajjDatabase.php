<?php

namespace App\Filament\Resources\HajjDatabaseResource\Pages;

use App\Filament\Resources\HajjDatabaseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHajjDatabase extends EditRecord
{
    protected static string $resource = HajjDatabaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
