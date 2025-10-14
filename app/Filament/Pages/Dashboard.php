<?php

namespace App\Filament\Pages;

use App\Filament\Resources\RecordSetResource\Pages\CreateRecordSet;
use Filament\Actions\Action;
use Filament\Support\Icons\Heroicon;
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

    protected function getHeaderActions(): array
    {
        return [
            Action::make('add-set')
                ->label(__('pages.record_sets.add_set'))
                ->url(CreateRecordSet::getUrl())
                ->icon(Heroicon::PlusCircle)
                ->color('success')
                ->size('md')
                ->button(),
        ];
    }
}
