<?php

namespace App\Filament\Resources\WeightResource\Schemas;

use App\Filament\AbstractFormSchema;
use App\Services\Settings\Tenant;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class WeightForm extends AbstractFormSchema
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->default(auth()->id())
                    ->required(),

                TextInput::make('weight')
                    ->required()
                    ->suffix(Tenant::getWeightUnitLabel())
                    ->minValue(1)
                    ->integer(),

                DatePicker::make('measured_at')
                    ->label('Measured Date')
                    ->default(now())
                    ->required(),
            ]);
    }
}
