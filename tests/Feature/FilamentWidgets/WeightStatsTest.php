<?php

namespace Tests\Feature\FilamentWidgets;

use App\Filament\Resources\WeightResource\Widgets\WeightStats;
use App\Models\Tenant;
use App\Models\Weight;
use App\Services\Settings\Enums\UnitType;
use Livewire\Livewire;

class WeightStatsTest extends BaseWidgetTestCase
{
    public function test_can_load_widget_no_weight_data()
    {
        Livewire::test(WeightStats::class)
            ->assertOk()
            ->assertSee('BMI')
            ->assertSee('N/A');
    }

    public function test_can_load_widget_no_height_data()
    {
        Weight::factory()->create();

        Livewire::test(WeightStats::class)
            ->assertOk()
            ->assertSee('BMI')
            ->assertSee('N/A');
    }

    public function test_can_show_bmi_data()
    {
        auth()->user()->update(['height' => 164]);
        Tenant::first()->update([
            'unit_type' => UnitType::METRIC,
        ]);
        Weight::factory()->create([
            'user_id' => auth()->id(),
            'weight' => 170,
        ]);

        Livewire::test(WeightStats::class)
            ->assertOk()
            ->assertSee('BMI')
            ->assertDontSee('N/A');
    }
}
