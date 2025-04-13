<?php

namespace App\Filament\Widgets;

use App\Models\HajjDatabase;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class HajjDatabaseTableWidget extends BaseWidget
{
    protected static ?int $sort = 3; // Ensures the widget order in the dashboard

    public function getTableHeading(): string
    {
        return __('hajj_database_table.latest_hajj_databases'); // Use translation
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(HajjDatabase::query()->latest()->take(3)) // Fetch latest 3 Hajj Databases
            ->columns([
                Tables\Columns\TextColumn::make('name')->label(__('hajj_database_table.database_name')),
                Tables\Columns\TextColumn::make('created_at')->label(__('hajj_database_table.created_at'))->dateTime(),
            ])
            ->paginated(false); // Disables pagination
    }
}
