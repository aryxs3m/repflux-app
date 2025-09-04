<?php

namespace App\Filament\Resources\MeasurementResource\Pages;

use App\Filament\Resources\MeasurementResource;
use App\Models\Measurement;
use App\Models\MeasurementType;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\EditRecord;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;

class AddBulkMeasurement extends CreateRecord
{
    protected static string $resource = MeasurementResource::class;

    public function form(Schema $schema): Schema
    {
        $components = [];

        foreach (MeasurementType::query()->get() as $item) {
            $components[] = TextInput::make('measurement_type_' . $item->id)
                ->label($item->name)
                ->suffix('cm')
                ->minValue(0)
                ->nullable()
                ->columnSpan('full')
                ->integer();
        }

        return $schema->components($components);
    }

    protected function handleRecordCreation(array $data): Model
    {
        $insert = array_map(function ($key, $value) {
            return [
                'measurement_type_id' => (int) str_replace('measurement_type_', '', $key),
                'value' => (int) $value,
                'measured_at' => now(),
                'user_id' => auth()->id(),
            ];
        }, array_keys($data), $data);

        Measurement::query()->insert($insert);

        // Dummy return to satisfy the method signature
        return new Measurement();
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
