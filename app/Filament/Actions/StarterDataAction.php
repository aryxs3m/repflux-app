<?php

namespace App\Filament\Actions;

use App\Services\Settings\Tenant;
use App\Services\StarterData\StarterDataSeeder;
use BackedEnum;
use Closure;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;

/**
 * Seeds the database (current tenant) with the given starter data class.
 */
class StarterDataAction extends Action
{
    protected StarterDataSeeder|string $seeder;

    public function setSeeder(StarterDataSeeder|string $seeder): static
    {
        $this->seeder = $seeder;

        return $this;
    }

    public static function getDefaultName(): ?string
    {
        return 'load_starter_data';
    }

    public function getLabel(): string|Htmlable|null
    {
        return __('common.load_default');
    }

    public function getIcon(BackedEnum|string|null $default = null): string|BackedEnum|Htmlable|null
    {
        return Heroicon::FolderPlus;
    }

    public function getColor(): string|array|null
    {
        return 'gray';
    }

    public function getActionFunction(): ?Closure
    {
        return function () {
            $this->seeder::seed(Tenant::getTenant());

            Notification::make()
                ->success()
                ->title(__('notifications.success'))
                ->body(__('notifications.starter_data_loaded'))
                ->send();

            $this->success();
        };
    }
}
