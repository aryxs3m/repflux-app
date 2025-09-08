<?php

namespace App\Filament\Resources\MeasurementResource\Pages;

use App\Filament\Resources\MeasurementResource;
use App\Models\Measurement;
use App\Models\MeasurementType;
use App\Services\Settings\TenantSettings;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\CreateRecord;
use Filament\Schemas\Schema;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

class AddBulkMeasurement extends CreateRecord
{
    protected static string $resource = MeasurementResource::class;

    public function getTitle(): string|Htmlable
    {
        return __('pages.measurements.bulk_create_title');
    }

    public function form(Schema $schema): Schema
    {
        $components = [];

        foreach (MeasurementType::query()->get() as $item) {
            $components[] = TextInput::make('measurement_type_'.$item->id)
                ->label($item->name)
                ->suffix(TenantSettings::getLengthUnitLabel())
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
                'tenant_id' => TenantSettings::getTenant()->id,
            ];
        }, array_keys($data), $data);

        Measurement::query()->insert($insert);

        // Dummy return to satisfy the method signature
        return new Measurement;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
