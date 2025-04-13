<?php

namespace App\Filament\Resources\HajjParticipantResource\Pages;

use App\Filament\Resources\HajjParticipantResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\HajjDatabaseResource;
use App\Filament\Traits\HasParentResource;

class CreateHajjParticipant extends CreateRecord
{
    use HasParentResource;

    protected static string $resource = HajjParticipantResource::class;
    
    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? static::getParentResource()::getUrl('hajj-participants.index', [
            'parent' => $this->parent,
        ]);
    }

    // Optionally move this logic to a Trait if used repeatedly across resources
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Automatically set the parent relationship key (`hajj_database_id`) with the parent's ID.
        $data[$this->getParentRelationshipKey()] = $this->parent->id;

        return $data;
    }
}
