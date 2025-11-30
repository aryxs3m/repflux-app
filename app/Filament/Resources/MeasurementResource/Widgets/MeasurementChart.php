<?php

namespace App\Filament\Resources\MeasurementResource\Widgets;

use App\Models\Measurement;
use App\Models\MeasurementType;
use App\Services\Settings\Tenant;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Collection;

class MeasurementChart extends ChartWidget
{
    protected ?string $heading = 'Measurement Chart';

    protected int|string|array $columnSpan = 'full';

    public ?string $filter = null;

    public function __construct()
    {
        $this->filter = auth()->user()->id;
    }

    protected function getFilters(): ?array
    {
        return Tenant::getTenant()->users()->pluck('name', 'id')->toArray();
    }

    protected function getRawData(): Collection
    {
        return Measurement::query()
            ->where('tenant_id', '=', Tenant::getTenant()->id)
            ->where('user_id', '=', $this->filter)
            ->where('measured_at', '>', now()->subYear())
            ->orderBy('measured_at')
            ->get();
    }

    protected function getData(): array
    {
        $data = $this->getRawData();

        $datasets = [];

        foreach (MeasurementType::all() as $item) {
            $datasets[] = [
                'label' => $item->name,
                'data' => $data->where('measurement_type_id', $item->id)->pluck('value')->toArray(),
            ];
        }

        return [
            'datasets' => $datasets,
            'labels' => array_values($data->pluck('measured_at')->map(fn ($date) => $date->format('Y-m-d'))->unique()->toArray()),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
