<?php

namespace App\Filament\Resources\MeasurementTypeResource\Schemas;

use App\Filament\AbstractFormSchema;
use App\Models\MeasurementType;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class MeasurementTypeForm extends AbstractFormSchema
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),

                TextEntry::make('created_at')
                    ->label('Created Date')
                    ->state(fn (?MeasurementType $record): string => $record?->created_at?->diffForHumans() ?? '-'),

                TextEntry::make('updated_at')
                    ->label('Last Modified Date')
                    ->state(fn (?MeasurementType $record): string => $record?->updated_at?->diffForHumans() ?? '-'),
            ]);
    }
}
