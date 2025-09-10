<?php

namespace App\Filament\Pages;

use App\Services\Settings\TenantSettings;
use Filament\Auth\Pages\EditProfile as BaseEditProfile;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EditProfile extends BaseEditProfile
{
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Account')->schema([
                    $this->getNameFormComponent(),
                    $this->getEmailFormComponent(),
                    $this->getPasswordFormComponent(),
                    $this->getPasswordConfirmationFormComponent(),
                ]),
                Section::make('Health')->schema([
                    TextInput::make('height')
                        ->minValue(0)
                        ->suffix(TenantSettings::getTenant() ? TenantSettings::getLengthUnitLabel() : null)
                        ->nullable(),
                ]),
                Section::make('Preferences')->schema([
                    Select::make('language')
                        ->options([
                            'en' => 'English',
                            'hu' => 'Hungarian',
                        ])
                        ->nullable()
                        ->placeholder('Automatic by browser')
                        ->default(null),
                ]),
                Section::make('Notifications')->schema([
                    Fieldset::make('Weight')->schema([
                        Toggle::make('notify_measurement_weight')
                            ->label('Enabled'),
                        TextInput::make('notify_measurement_weight_days')
                            ->label('After')
                            ->suffix('days'),
                    ]),
                    Fieldset::make('Body')->schema([
                        Toggle::make('notify_measurement_body')
                            ->label('Enabled'),
                        TextInput::make('notify_measurement_body_days')
                            ->label('After')
                            ->suffix('days'),
                    ]),
                ]),
            ]);
    }
}
