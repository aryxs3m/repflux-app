<?php

namespace App\Filament\Resources\WorkoutResource\Schemas;

use App\Filament\Abstract\Schema\AbstractFormSchema;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class WorkoutForm extends AbstractFormSchema
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Basic')
                    ->schema([
                        DateTimePicker::make('workout_at')
                            ->label('Workout Date')
                            ->default(now()),
                        Textarea::make('notes')
                            ->nullable(),
                    ]),
            ])
            ->columns(1);
    }
}
