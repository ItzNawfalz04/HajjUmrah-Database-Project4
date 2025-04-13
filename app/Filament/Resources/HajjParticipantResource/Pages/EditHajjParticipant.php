<?php

namespace App\Filament\Resources\HajjParticipantResource\Pages;

use App\Filament\Resources\HajjParticipantResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\HajjDatabaseResource;
use App\Filament\Traits\HasParentResource;

class EditHajjParticipant extends EditRecord
{
    use HasParentResource;

    protected static string $resource = HajjParticipantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? static::getParentResource()::getUrl('hajj-participants.index', [
            'parent' => $this->parent,
        ]);
    }

    protected function configureDeleteAction(Actions\DeleteAction $action): void
    {
        $resource = static::getResource();

        $action->authorize($resource::canDelete($this->getRecord()))
            ->successRedirectUrl(static::getParentResource()::getUrl('hajj-participants.index', [
                'parent' => $this->parent,
            ]));
    }
}
