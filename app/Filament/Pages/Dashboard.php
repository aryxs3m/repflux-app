<?php

namespace App\Filament\Pages;

use Illuminate\Contracts\Support\Htmlable;

class Dashboard extends \Filament\Pages\Dashboard
{
    /**
     * @return string|null
     */
    public static function getNavigationLabel(): string
    {
        return __('pages.dashboard.title');
    }

    public function getTitle(): string|Htmlable
    {
        return __('pages.dashboard.title');
    }
}
