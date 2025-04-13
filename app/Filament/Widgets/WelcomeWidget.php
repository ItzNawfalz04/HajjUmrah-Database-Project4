<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class WelcomeWidget extends Widget
{
    protected static string $view = 'filament.widgets.welcome-widget';

    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 0; // Ensure it's at the top

    public static function canView(): bool
    {
        return true; // Show to all authenticated users
    }
}
