<?php

namespace App\Filament\Resources\UmrahParticipantResource\Pages;

use App\Filament\Resources\UmrahParticipantResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\UmrahDatabaseResource;
use App\Filament\Traits\HasParentResource;


class EditUmrahParticipant extends EditRecord
{
    use HasParentResource;

    protected static string $resource = UmrahParticipantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? static::getParentResource()::getUrl('umrah-participants.index', [
            'parent' => $this->parent,
        ]);
    }

    protected function configureDeleteAction(Actions\DeleteAction $action): void
    {
        $resource = static::getResource();

        $action->authorize($resource::canDelete($this->getRecord()))
            ->successRedirectUrl(static::getParentResource()::getUrl('umrah-participants.index', [
                'parent' => $this->parent,
            ]));
    }
}
