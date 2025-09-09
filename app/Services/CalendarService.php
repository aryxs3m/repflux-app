<?php

namespace App\Services;

use App\Models\Measurement;
use App\Models\RecordSet;
use App\Models\Tenant;
use App\Models\Weight;
use Carbon\Carbon;

class CalendarService
{
    public function getEvents(Tenant $tenant, Carbon $start, Carbon $end): array
    {
        return array_merge(
            $this->getRecordCategories($tenant, $start, $end),
            $this->getMeasurements($tenant, $start, $end),
            $this->getWeights($tenant, $start, $end)
        );
    }

    protected function getRecordCategories(Tenant $tenant, Carbon $start, Carbon $end): array
    {
        return RecordSet::query()
            ->where('tenant_id', $tenant->id)
            ->whereBetween('set_done_at', [$start->toDateString(), $end->toDateString()])
            ->get()
            ->map(function (RecordSet $recordSet) {
                return [
                    'title' => sprintf('%s - %s', $recordSet->recordType->recordCategory->name, $recordSet->recordType->name),
                    'start' => $recordSet->set_done_at,
                    'end' => clone $recordSet->set_done_at->addHour(),
                ];
            })
            ->toArray();
    }

    protected function getMeasurements(Tenant $tenant, Carbon $start, Carbon $end): array
    {
        return Measurement::query()
            ->where('tenant_id', $tenant->id)
            ->whereBetween('measured_at', [$start->toDateString(), $end->toDateString()])
            ->get()
            ->map(function (Measurement $measurement) {
                return [
                    'title' => __('pages.calendar.event.body_measurement'),
                    'backgroundColor' => 'yellow',
                    'start' => $measurement->measured_at,
                    'end' => clone $measurement->measured_at->addHour(),
                ];
            })
            ->toArray();
    }

    protected function getWeights(Tenant $tenant, Carbon $start, Carbon $end): array
    {
        return Weight::query()
            ->where('tenant_id', $tenant->id)
            ->whereBetween('measured_at', [$start->toDateString(), $end->toDateString()])
            ->get()
            ->map(function (Weight $weight) {
                return [
                    'title' => __('pages.calendar.event.weight_measurement'),
                    'backgroundColor' => 'green',
                    'start' => $weight->measured_at,
                    'end' => clone $weight->measured_at->addHour(),
                ];
            })
            ->toArray();
    }
}
