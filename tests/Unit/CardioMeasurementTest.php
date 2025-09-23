<?php

namespace Tests\Unit;

use App\Filament\Resources\RecordTypeResource\CardioMeasurement;
use App\Filament\Resources\RecordTypeResource\CardioMeasurementTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\TestCase;
use Mockery\MockInterface;

class CardioMeasurementTest extends TestCase
{
    public function test_can_get_label_for_every_case()
    {
        foreach (CardioMeasurement::cases() as $case) {
            $this->assertNotEmpty($case->getLabel());
        }
    }

    public function test_can_get_measurement_unit_for_every_case()
    {
        foreach (CardioMeasurement::cases() as $case) {
            $this->assertNotNull($case->getMeasurementUnit());
        }
    }

    public function test_can_create_input_for_every_case()
    {
        foreach (CardioMeasurement::cases() as $case) {
            $input = CardioMeasurementTransformer::getInput($case);

            $this->assertNotNull($input);
            $this->assertEquals(0, $input->getMinValue());
            $this->assertStringStartsWith('cardio_measurement_', $input->getName());
        }
    }

    public function test_can_get_measurement_value_for_cases()
    {
        foreach (CardioMeasurement::cases() as $case) {
            /** @var Model $model */
            $model = $this->mock(Model::class, function (MockInterface $mock) use ($case) {
                $mock->shouldReceive('getAttribute')
                    ->with('cardio_measurement_'.$case->value)
                    ->andReturn(1337);
            });

            $output = CardioMeasurementTransformer::get($model, $case);

            $this->assertNotNull($output);
            $this->assertStringStartsWith('1337', $output);
        }
    }
}
