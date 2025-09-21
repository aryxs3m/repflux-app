<?php

namespace Tests\Unit\Utilities;

use App\Utilities\Trend;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Support\Collection;
use Mockery\MockInterface;

class TrendTest extends TestCase
{
    protected function generateModels(): array
    {
        /** @var Model $model */
        $modelA = $this->mock(Model::class, function (MockInterface $mock) {
            $mock->shouldReceive('getAttribute')
                ->with('value')
                ->andReturn(0);

            $mock->shouldReceive('getAttribute')
                ->with('created_at')
                ->andReturn(Carbon::parse('2025-01-01 00:00:00'));
        });

        /** @var Model $model */
        $modelB = $this->mock(Model::class, function (MockInterface $mock) {
            $mock->shouldReceive('getAttribute')
                ->with('value')
                ->andReturn(100);

            $mock->shouldReceive('getAttribute')
                ->with('created_at')
                ->andReturn(Carbon::parse('2025-01-11 00:00:00'));
        });

        return [$modelA, $modelB];
    }

    public function test_can_get_daily_progression_by_array(): void
    {
        $models = $this->generateModels();

        $trend = Trend::calculate(
            $models,
            'value',
            'created_at',
            1
        );

        $this->assertEquals(10, $trend);
    }

    public function test_can_get_daily_progression_by_array_newer_first(): void
    {
        $models = $this->generateModels();

        $trend = Trend::calculate(
            array_reverse($models),
            'value',
            'created_at',
            1
        );

        $this->assertEquals(10, $trend);
    }

    public function test_can_get_weekly_progression_by_array(): void
    {
        $models = $this->generateModels();

        $trend = Trend::calculate(
            $models,
            'value',
            'created_at',
            7
        );

        $this->assertEquals(70, $trend);
    }

    public function test_can_get_daily_progression_by_collection(): void
    {
        $models = $this->generateModels();

        $trend = Trend::calculate(
            Collection::make($models),
            'value',
            'created_at',
            1
        );

        $this->assertEquals(10, $trend);
    }

    public function test_can_get_weekly_progression_by_collection(): void
    {
        $models = $this->generateModels();

        $trend = Trend::calculate(
            Collection::make($models),
            'value',
            'created_at',
            7
        );

        $this->assertEquals(70, $trend);
    }
}
