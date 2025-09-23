<?php

namespace App\Filament\Resources\RecordTypeResource\Schemas;

use App\Filament\AbstractFormSchema;
use App\Filament\Resources\RecordTypeResource\CardioMeasurement;
use App\Models\RecordType;
use App\Services\Settings\Tenant;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class RecordTypeForm extends AbstractFormSchema
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('pages.record_types.basic_settings'))->schema([
                    Select::make('record_category_id')
                        ->relationship('recordCategory', 'name')
                        ->required(),

                    TextInput::make('name')
                        ->required(),

                    Radio::make('exercise_type')
                        ->live()
                        ->options([
                            'weight' => 'Weight',
                            'cardio' => 'Cardio',
                            'other' => 'Other',
                        ])
                        ->descriptions([
                            'weight' => 'Súlyzós gyakorlat, pl. bench press, oldalemelés vagy kötél',
                            'cardio' => 'Kardió, pl. futás, airbike, evezőgép, futópad',
                            'other' => 'Egyéb, pl. saját testsúlyos gyakorlat, TRX',
                        ]),
                ]),

                Section::make(__('pages.record_types.other'))->schema([
                    Textarea::make('notes')
                        ->nullable(),
                ]),

                Section::make('Részletek')->schema([
                    TextInput::make('base_weight')
                        ->default(0)
                        ->suffix(Tenant::getWeightUnitLabel())
                        ->visible(fn (Get $get) => $get('exercise_type') === 'weight'),

                    Select::make('cardio_measurements')
                        ->multiple()
                        ->options(CardioMeasurement::class)
                        ->visible(fn (Get $get) => $get('exercise_type') === 'cardio'),
                ])->columnSpanFull(),

                TextEntry::make('created_at')
                    ->label('Created Date')
                    ->state(fn (?RecordType $record): string => $record?->created_at?->diffForHumans() ?? '-'),

                TextEntry::make('updated_at')
                    ->label('Last Modified Date')
                    ->state(fn (?RecordType $record): string => $record?->updated_at?->diffForHumans() ?? '-'),
            ]);
    }
}
