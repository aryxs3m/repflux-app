<?php

namespace Tests\Unit;

use App\Filament\Resources\RecordTypeResource\CardioMeasurement;
use App\Filament\Resources\RecordTypeResource\CardioMeasurementTransformer;
use App\Models\RecordSet;
use App\Models\RecordType;
use Filament\Infolists\Components\TextEntry;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\TestCase;
use Mockery\MockInterface;

class CardioMeasurementTest extends TestCase
{
    public function test_can_get_label_for_every_case()
    {
        foreach (CardioMeasurement::cases() as $case) {
            $this->assertNotEmpty($case->getLabel());
            $this->assertStringNotContainsString('measurement.', $case->getLabel());
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

    public function test_can_create_entry_for_any_enabled_case()
    {
        foreach (CardioMeasurement::cases() as $case) {
            /** @var RecordSet $model */
            $model = $this->mock(RecordSet::class, function (MockInterface $mock) use ($case) {
                $recordType = $this->mock(RecordType::class, function (MockInterface $mock) use ($case) {
                    $mock->shouldReceive('getAttribute')
                        ->with('cardio_measurements')
                        ->andReturn([
                            $case->value,
                        ]);
                });

                $mock->shouldReceive('getAttribute')
                    ->with('recordType')
                    ->andReturn($recordType);
            });

            $output = CardioMeasurementTransformer::getEntries($model);

            $this->assertNotNull($output);
            $this->assertCount(1, $output);
            $this->assertInstanceOf(TextEntry::class, $output[0]);
        }
    }

    public function test_can_create_entry_for_all_enabled_cases()
    {
        /** @var RecordSet $model */
        $model = $this->mock(RecordSet::class, function (MockInterface $mock) {
            $recordType = $this->mock(RecordType::class, function (MockInterface $mock) {
                $mock->shouldReceive('getAttribute')
                    ->with('cardio_measurements')
                    ->andReturn(array_map(function ($case) {
                        return $case->value;
                    }, CardioMeasurement::cases()));
            });

            $mock->shouldReceive('getAttribute')
                ->with('recordType')
                ->andReturn($recordType);
        });

        $output = CardioMeasurementTransformer::getEntries($model);

        $this->assertNotNull($output);
        $this->assertCount(count(CardioMeasurement::cases()), $output);
        foreach ($output as $item) {
            $this->assertInstanceOf(TextEntry::class, $item);
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
