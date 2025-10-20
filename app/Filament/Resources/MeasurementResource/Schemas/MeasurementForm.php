<?php

namespace App\Filament\Resources\MeasurementResource\Schemas;

use App\Filament\AbstractFormSchema;
use App\Filament\Fields\UserSelect;
use App\Models\Measurement;
use App\Services\Settings\Tenant;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class MeasurementForm extends AbstractFormSchema
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                UserSelect::make()
                    ->defaultSelf(),

                Select::make('measurement_type_id')
                    ->relationship('measurementType', 'name')
                    ->required(),

                DatePicker::make('measured_at')
                    ->label('Measured Date')
                    ->default(now()),

                TextInput::make('value')
                    ->required()
                    ->suffix(Tenant::getLengthUnitLabel())
                    ->integer(),

                TextEntry::make('created_at')
                    ->label('Created Date')
                    ->state(fn (?Measurement $record): string => $record?->created_at?->diffForHumans() ?? '-'),

                TextEntry::make('updated_at')
                    ->label('Last Modified Date')
                    ->state(fn (?Measurement $record): string => $record?->updated_at?->diffForHumans() ?? '-'),
            ]);
    }
}
