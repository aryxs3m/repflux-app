<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;

class Calendar extends Page
{
    protected string $view = 'filament.pages.calendar';

    public static function getNavigationLabel(): string
    {
        return __('pages.calendar.title');
    }

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    public function getTitle(): string|Htmlable
    {
        return __('pages.calendar.title');
    }
}
