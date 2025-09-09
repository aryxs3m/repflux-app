<?php

namespace App\Filament\Pages\Tenancy;

use App\Models\Tenant;
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
                    ->default(auth()->user()->name.'\'s tenant')
                    ->required(),
                Select::make('unit_type')
                    ->options([
                        'metric' => 'Metric (kg, cm)',
                        'imperial' => 'Imperial (lbs, in)',
                    ])
                    ->default('metric')
                    ->required(),
            ]);
    }

    protected function handleRegistration(array $data): Tenant
    {
        $team = Tenant::create($data);
        $team->users()->attach(auth()->user(), ['is_admin' => true]);

        return $team;
    }
}
