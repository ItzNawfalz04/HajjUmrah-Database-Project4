<?php

namespace App\Filament\Resources\HajjParticipantResource\Pages;

use App\Filament\Resources\HajjParticipantResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\HasParentResource;
use App\Filament\Resources\HajjDatabaseResource;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
use pxlrbt\FilamentExcel\Actions\BulkAction;
use Filament\Actions\Action;


class ListHajjParticipants extends ListRecords
{
    use HasParentResource;

    protected static string $resource = HajjParticipantResource::class;
    
    protected function getHeaderActions(): array
    {
        return [
            //Actions\CreateAction::make(),
            Actions\CreateAction::make()
                ->label(__('hajj_participant.buttons.create_button_label')) // Custom button label
                ->url(
                    fn (): string => static::getParentResource()::getUrl('hajj-participants.create', [
                        'parent' => $this->parent,
                    ])
                ),
            ExportAction::make()
                ->color("info")
                ->icon('heroicon-o-arrow-down-tray')
                ->label('Export Out')
                ->exports([
                    ExcelExport::make()
                        ->fromTable()
                        ->withFilename(fn ($resource) => $resource::getModelLabel() . '-' . date('d-m-Y'))
                        ->withWriterType(\Maatwebsite\Excel\Excel::XLSX)
                        ->withColumns([
                            Column::make('updated_at'),
                            Column::make('family_member'),
                            Column::make('waris')
                                ->formatStateUsing(fn ($state) => $state . " "), // Add single quote to force Excel to treat it as text
                        ])
                ]),
            \EightyNine\ExcelImport\ExcelImportAction::make()
                ->color("success")
                ->icon('heroicon-o-arrow-up-tray')
                ->label('Import In')
                ->beforeImport(function (array $data, $livewire, $excelImportAction) {
                    // Retrieve the current hajj_database_id from the Livewire component
                    $hajjDatabaseId = $livewire->parent->id ?? null;

                    // Ensure we have a valid database ID
                    if (!$hajjDatabaseId) {
                        throw new \Exception("Hajj Database ID is missing.");
                    }

                    // Automatically add hajj_database_id to all imported rows
                    $excelImportAction->additionalData([
                        'hajj_database_id' => $hajjDatabaseId
                    ]);
                }),

                 // Download Template Button
                Action::make('download_template')
                    ->label('Download Template')
                    ->color('danger')
                    ->icon('heroicon-o-document-arrow-down')
                    ->url(route('download.hajj-template'))
                    ->openUrlInNewTab(),

        ];
    }
}
