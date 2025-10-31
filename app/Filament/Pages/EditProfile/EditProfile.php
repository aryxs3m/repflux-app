<?php

namespace App\Filament\Pages\EditProfile;

use App\Services\Settings\Tenant;
use Filament\Auth\Pages\EditProfile as BaseEditProfile;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Colors\Color;

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
                        ->suffix(Tenant::getTenant() ? Tenant::getLengthUnitLabel() : null)
                        ->nullable(),
                    TextInput::make('weight_target')
                        ->minValue(0)
                        ->suffix(Tenant::getTenant() ? Tenant::getWeightUnitLabel() : null)
                        ->nullable(),
                ]),
                Section::make('Preferences')->schema([
                    Select::make('color')
                        ->nullable()
                        ->placeholder('(nincs szín)')
                        ->options([
                            'danger' => 'Red',
                            'warning' => 'Yellow',
                            'success' => 'Green',
                            'info' => 'Blue',
                        ]),
                    Select::make('language')
                        ->options([
                            'en' => 'English',
                            'hu' => 'Magyar',
                        ])
                        ->nullable()
                        ->placeholder(__('pages.edit_profile.system_default'))
                        ->default(null),
                    Fieldset::make('Number format')->schema([
                        TextInput::make('number_format_decimals')
                            ->label('Decimals')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(6),
                        TextInput::make('number_format_decimal_separator')
                            ->label('Decimal separator')
                            ->minLength(0)
                            ->maxLength(1),
                        TextInput::make('number_format_thousands_separator')
                            ->label('Thousands separator')
                            ->minLength(0)
                            ->maxLength(1),
                    ]),
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
                Section::make('Account deletion')->schema([
                    DeleteProfileAction::make(),
                ]),
            ]);
    }
}
