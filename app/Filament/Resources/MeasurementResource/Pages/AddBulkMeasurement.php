<?php

namespace App\Filament\Resources\MeasurementResource\Pages;

use App\Filament\Fields\UserSelect;
use App\Filament\Resources\MeasurementResource;
use App\Models\Measurement;
use App\Models\MeasurementType;
use App\Services\Settings\Tenant;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\CreateRecord;
use Filament\Schemas\Components\Section;
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

        $measurementTypes = MeasurementType::query()
            ->where('tenant_id', Tenant::getTenant()->id)
            ->get();

        foreach ($measurementTypes as $item) {
            $components[] = TextInput::make($item->id)
                ->label($item->name)
                ->suffix(Tenant::getLengthUnitLabel())
                ->minValue(0)
                ->nullable()
                ->columnSpan('full')
                ->integer();
        }

        return $schema->components([
            Section::make('Settings')->schema([
                UserSelect::make()
                    ->defaultSelf(),
                DatePicker::make('measured_at')
                    ->default(now()),
            ]),
            Section::make('Measurements')
                ->statePath('measurements')
                ->childComponents($components),
        ])->columns(1);
    }

    protected function handleRecordCreation(array $data): Model
    {
        $insert = array_map(function ($key, $value) use ($data) {
            return [
                'created_at' => now(),
                'measurement_type_id' => (int) $key,
                'value' => (int) $value,
                'measured_at' => $data['measured_at'],
                'user_id' => $data['user_id'],
                'tenant_id' => Tenant::getTenant()->id,
            ];
        }, array_keys($data['measurements']), $data['measurements']);

        Measurement::query()->insert($insert);

        // Dummy return to satisfy the method signature
        return new Measurement;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
