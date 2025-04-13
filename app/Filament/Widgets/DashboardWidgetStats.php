<?php

namespace App\Filament\Widgets;

use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\HajjDatabase;
use App\Models\UmrahDatabase;
use App\Models\HajjParticipant;
use App\Models\UmrahParticipant;

class DashboardWidgetStats extends BaseWidget
{
    protected static ?int $sort = 2; // Ensures the widget order in the dashboard

    public static string $Label = 'Dashboard Stats';protected function getHeading(): ?string
    {
        return __('dashboard_stats.label');
    }

    protected function getStats(): array
    {
        return [
            Stat::make(__('dashboard_stats.total_database'), HajjDatabase::count() + UmrahDatabase::count())
                ->description(__('dashboard_stats.total_database_description'))
                ->Icon('heroicon-m-circle-stack')
                ->color('primary'),
                
            Stat::make(__('dashboard_stats.hajj_participant'), HajjParticipant::count())
                ->description(__('dashboard_stats.hajj_participant_description'))
                ->Icon('heroicon-m-users')
                ->color('primary'),

            Stat::make(__('dashboard_stats.umrah_participant'), UmrahParticipant::count())
                ->description(__('dashboard_stats.umrah_participant_description'))
                ->Icon('heroicon-m-users')
                ->color('primary'),
        ];
    }
}
