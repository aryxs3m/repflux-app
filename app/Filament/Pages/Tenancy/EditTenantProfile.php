<?php

namespace App\Filament\Pages\Tenancy;

use App\Models\Tenant;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class EditTenantProfile extends \Filament\Pages\Tenancy\EditTenantProfile
{
    public static function getLabel(): string
    {
        return __('pages.tenancy.edit_tenant');
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
                        'imperial' => 'Imperial (lbs, ft)',
                    ])
                    ->default('metric')
                    ->required(),
                Select::make('language')
                    ->options([
                        'de' => '<Automatic by browser>',
                        'en' => 'English',
                        'hu' => 'Hungarian',
                    ])
                    ->nullable()
                    ->default(null)
            ]);
    }
}

