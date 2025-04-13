<?php

namespace App\Filament\Resources\UmrahParticipantResource\Pages;

use App\Filament\Resources\UmrahParticipantResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\HasParentResource;
use App\Filament\Resources\UmrahDatabaseResource;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
use pxlrbt\FilamentExcel\Actions\BulkAction;
use Filament\Actions\Action;

class ListUmrahParticipants extends ListRecords
{
    use HasParentResource;
    
    protected static string $resource = UmrahParticipantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //Actions\CreateAction::make(),
            Actions\CreateAction::make()
                ->label(__('umrah_participant.buttons.create_button_label')) // Custom button label
                ->url(
                    fn (): string => static::getParentResource()::getUrl('umrah-participants.create', [
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
                        ->withFilename(fn ($resource) => $resource::getModelLabel() . '-' . date('Y-m-d'))
                        ->withWriterType(\Maatwebsite\Excel\Excel::XLSX)
                        ->withColumns([
                            Column::make('updated_at'),
                            Column::make('family_member'),
                            Column::make('ic_no')
                                ->formatStateUsing(fn ($state) => $state . " "), // Add single quote to force Excel to treat it as text
                        ])
                ]),
            \EightyNine\ExcelImport\ExcelImportAction::make()
                ->color("success")
                ->icon('heroicon-o-arrow-up-tray')
                ->label('Import In')
                ->beforeImport(function (array $data, $livewire, $excelImportAction) {
                    // Retrieve the current umrah_database_id from the Livewire component
                    $umrahDatabaseId = $livewire->parent->id ?? null;

                    // Ensure we have a valid database ID
                    if (!$umrahDatabaseId) {
                        throw new \Exception("Umrah Database ID is missing.");
                    }

                    // Automatically add umrah_database_id to all imported rows
                    $excelImportAction->additionalData([
                        'umrah_database_id' => $umrahDatabaseId
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
