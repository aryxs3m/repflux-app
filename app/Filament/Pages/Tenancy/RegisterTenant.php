<?php

namespace App\Filament\Pages\Tenancy;

use App\Models\Tenant;
use App\Services\StarterData\StarterDataService;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class RegisterTenant extends \Filament\Pages\Tenancy\RegisterTenant
{
    public static function getLabel(): string
    {
        return __('pages.tenancy.register_tenant');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->default(__('pages.tenancy.default_tenant_name', ['user' => auth()->user()->name]))
                    ->required(),
                Select::make('unit_type')
                    ->options([
                        'metric' => 'Metric (kg, cm)',
                        'imperial' => 'Imperial (lbs, in)',
                    ])
                    ->default('metric')
                    ->required(),
                Checkbox::make('seed')
                    ->label('Create exercises, categories and measurements')
                    ->inline(),
            ]);
    }

    protected function handleRegistration(array $data): Tenant
    {
        $team = Tenant::create($data);
        $team->users()->attach(auth()->user(), ['is_admin' => true]);

        if ($data['seed']) {
            app(StarterDataService::class)->seed($team);
        }

        return $team;
    }
}
