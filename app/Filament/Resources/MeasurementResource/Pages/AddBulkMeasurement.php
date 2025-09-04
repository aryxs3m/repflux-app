<?php

namespace App\Filament\Resources\MeasurementResource\Pages;

use App\Filament\Resources\MeasurementResource;
use App\Models\MeasurementType;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\EditRecord;
use Filament\Schemas\Schema;

class AddBulkMeasurement extends CreateRecord
{
    protected static string $resource = MeasurementResource::class;

    public function form(Schema $schema): Schema
    {
        $components = [];

        foreach (MeasurementType::query()->get() as $item) {
            $components[] = TextInput::make('value_' . $item->id)
                ->label($item->name)
                ->suffix('cm')
                ->minValue(0)
                ->nullable()
                ->columnSpan('full')
                ->integer();
        }

        return $schema->components($components);
    }
}
