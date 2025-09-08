<?php

namespace Tests\Services;

use App\Services\Bmi\BmiService;
use App\Services\Settings\Enums\UnitType;
use Exception;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class BmiServiceTest extends TestCase
{
    /**
     * Test data validated with the BMI calculator on Wikipedia.
     *
     * @return array
     * @url https://en.wikipedia.org/wiki/Body_mass_index
     */
    public static function bmiProvider(): array
    {
        // weight, height, unitType, bmi result
        return [
            [53, 24, UnitType::METRIC, 920.1],
            [10, 10, UnitType::METRIC, 1000],
            [1, 1, UnitType::METRIC, 10000],
            [10, 10, UnitType::IMPERIAL, 70.3],
            [5, 3, UnitType::IMPERIAL, 390.6],
        ];
    }

    /**
     * @throws Exception
     */
    #[DataProvider('bmiProvider')]
    public function testCalculate(int $weight, int $height, UnitType $type, float $bmi)
    {
        $result = app(BmiService::class)->calculate($height, $weight, $type);;

        $this->assertNotEmpty($result);
        $this->assertEquals($bmi, $result);
    }

    public function testThrowsExceptionWhenNoWeight(): void
    {
        $this->expectException(Exception::class);
        app(BmiService::class)->calculate(10, 0);
    }

    public function testThrowsExceptionWhenNoHeight(): void
    {
        $this->expectException(Exception::class);
        app(BmiService::class)->calculate(0, 10);
    }

    public function testThrowsExceptionWhenNoWeightAndHeight(): void
    {
        $this->expectException(Exception::class);
        app(BmiService::class)->calculate(0, 0);
    }
}
