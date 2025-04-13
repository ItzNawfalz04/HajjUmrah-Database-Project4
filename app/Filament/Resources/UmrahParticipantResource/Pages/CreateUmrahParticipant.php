<?php

namespace App\Filament\Resources\UmrahParticipantResource\Pages;

use App\Filament\Resources\UmrahParticipantResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\UmrahDatabaseResource;
use App\Filament\Traits\HasParentResource;

class CreateUmrahParticipant extends CreateRecord
{   
    use HasParentResource;
    protected static string $resource = UmrahParticipantResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? static::getParentResource()::getUrl('umrah-participants.index', [
            'parent' => $this->parent,
        ]);
    }

    // Optionally move this logic to a Trait if used repeatedly across resources
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Automatically set the parent relationship key (`umrah_database_id`) with the parent's ID.
        $data[$this->getParentRelationshipKey()] = $this->parent->id;

        return $data;
    }
}
