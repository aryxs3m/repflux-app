<?php

namespace App\Filament\Pages;

use App\Services\Settings\TenantSettings;
use Filament\Auth\Pages\EditProfile as BaseEditProfile;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
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
            ]);
    }
}
