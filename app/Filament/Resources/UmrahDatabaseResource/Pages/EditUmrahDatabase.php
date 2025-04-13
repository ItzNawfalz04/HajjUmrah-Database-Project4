<?php

namespace App\Filament\Resources\UmrahDatabaseResource\Pages;

use App\Filament\Resources\UmrahDatabaseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUmrahDatabase extends EditRecord
{
    protected static string $resource = UmrahDatabaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
