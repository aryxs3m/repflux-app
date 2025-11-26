<?php

namespace Feature;

use App\Models\Measurement;
use App\Models\RecordSet;
use App\Models\Tenant;
use App\Models\Weight;
use Carbon\Carbon;
use Tests\TestCase;

class CalendarEventsTest extends TestCase
{
    public function test_cant_get_results_when_unauthorized()
    {
        $this->actingAsGuest();

        $response = $this->call('GET', '/calendar/events/1', [
            'start' => Carbon::now()->startOfDay(),
            'end' => Carbon::now()->endOfDay(),
        ]);

        $response->assertStatus(302);
    }

    public function test_cant_get_result_without_date_filter()
    {
        $response = $this->call('GET', '/calendar/events/1');

        $response->assertInvalid(['start', 'end']);
    }

    public function test_cant_get_result_without_tenant()
    {
        $response = $this->call('GET', '/calendar/events', [
            'start' => Carbon::now()->startOfDay(),
            'end' => Carbon::now()->endOfDay(),
        ]);

        $response->assertStatus(404);
    }

    public function test_cant_get_result_with_invalid_tenant()
    {
        $response = $this->call('GET', '/calendar/events/2', [
            'start' => Carbon::now()->startOfDay(),
            'end' => Carbon::now()->endOfDay(),
        ]);

        $response->assertStatus(404);
    }

    public function test_cant_get_result_with_notpermitted_tenant()
    {
        $tenant = Tenant::factory()->create();
        $response = $this->call('GET', '/calendar/events/'.$tenant->id, [
            'start' => Carbon::now()->startOfDay(),
            'end' => Carbon::now()->endOfDay(),
        ]);

        $response->assertStatus(403);
    }

    public function test_can_get_empty_result()
    {
        $response = $this->call('GET', '/calendar/events/1', [
            'start' => Carbon::now()->startOfDay(),
            'end' => Carbon::now()->endOfDay(),
        ]);

        $response->assertStatus(200);
        $response->assertJson([]);
    }

    public function test_can_get_weight_measurement_event()
    {
        $weight = Weight::factory()->create([
            'user_id' => auth()->user()->id,
        ]);

        $response = $this->call('GET', '/calendar/events/1', [
            'start' => Carbon::now()->subDay()->startOfDay()->toDateTimeString(),
            'end' => Carbon::now()->addDay()->endOfDay()->toDateTimeString(),
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            [
                'title' => 'Testsúly napló',
                'start' => $weight->measured_at->toJSON(),
                'end' => $weight->measured_at->addHour()->toJSON(),
            ],
        ]);
    }

    public function test_can_get_body_measurement_event()
    {
        $measurement = Measurement::factory()->create([
            'user_id' => auth()->user()->id,
        ]);

        $response = $this->call('GET', '/calendar/events/1', [
            'start' => Carbon::now()->subDay()->startOfDay()->toDateTimeString(),
            'end' => Carbon::now()->addDay()->endOfDay()->toDateTimeString(),
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            [
                'title' => 'Testméret napló',
                'start' => $measurement->measured_at->toJSON(),
                'end' => $measurement->measured_at->addHour()->toJSON(),
            ],
        ]);
    }

    public function test_can_get_recordset_event()
    {
        $recordSet = RecordSet::factory()->create([
            'user_id' => auth()->user()->id,
        ]);

        $response = $this->call('GET', '/calendar/events/1', [
            'start' => Carbon::now()->subDay()->startOfDay()->toDateTimeString(),
            'end' => Carbon::now()->addDay()->endOfDay()->toDateTimeString(),
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            [
                'title' => $recordSet->recordType->recordCategory->name.' - '.$recordSet->recordType->name,
                'start' => $recordSet->set_done_at->toJSON(),
                'end' => $recordSet->set_done_at->addHour()->toJSON(),
            ],
        ]);
    }

    public function test_can_get_every_event_merged()
    {
        Weight::factory()->create([
            'user_id' => auth()->user()->id,
        ]);
        Measurement::factory()->create([
            'user_id' => auth()->user()->id,
        ]);
        RecordSet::factory()->create([
            'user_id' => auth()->user()->id,
        ]);

        $response = $this->call('GET', '/calendar/events/1', [
            'start' => Carbon::now()->subDay()->startOfDay()->toDateTimeString(),
            'end' => Carbon::now()->addDay()->endOfDay()->toDateTimeString(),
        ]);

        $response->assertStatus(200);
        $response->assertJsonCount(3);
    }

    public function test_same_events_not_duplicated()
    {
        Weight::factory()->create([
            'user_id' => auth()->user()->id,
        ]);
        Measurement::factory()->create([
            'user_id' => auth()->user()->id,
        ]);
        RecordSet::factory()->create([
            'user_id' => auth()->user()->id,
        ]);
        Weight::factory()->create([
            'user_id' => auth()->user()->id,
        ]);
        Measurement::factory()->create([
            'user_id' => auth()->user()->id,
        ]);
        RecordSet::factory()->create([
            'user_id' => auth()->user()->id,
        ]);

        $response = $this->call('GET', '/calendar/events/1', [
            'start' => Carbon::now()->subDay()->startOfDay()->toDateTimeString(),
            'end' => Carbon::now()->addDay()->endOfDay()->toDateTimeString(),
        ]);

        $response->assertStatus(200);

        // 2 recordset, 1 measurement, 1 weight
        $response->assertJsonCount(4);

        $this->assertCount(1, array_filter($response->json(), function ($item) {
            return $item['title'] == 'Testméret napló';
        }));
        $this->assertCount(1, array_filter($response->json(), function ($item) {
            return $item['title'] == 'Testsúly napló';
        }));
        $this->assertCount(2, array_filter($response->json(), function ($item) {
            return strpos($item['title'], ' - ');
        }));
    }
}
