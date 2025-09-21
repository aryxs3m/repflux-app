<?php

namespace Tests\Unit\Services;

use App\Services\Bmi\BmiCategory;
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

    public static function bmiCategoryProvider(): array
    {
        return [
            [-1000, BmiCategory::SEVERE_UNDERWEIGHT],
            [15, BmiCategory::SEVERE_UNDERWEIGHT],
            [16, BmiCategory::MODERATE_UNDERWEIGHT],
            [16.5, BmiCategory::MODERATE_UNDERWEIGHT],
            [17, BmiCategory::MILD_UNDERWEIGHT],
            [18, BmiCategory::MILD_UNDERWEIGHT],
            [18.4, BmiCategory::MILD_UNDERWEIGHT],
            [18.4999999999999, BmiCategory::MILD_UNDERWEIGHT],
            [18.5, BmiCategory::NORMAL],
            [20, BmiCategory::NORMAL],
            [22, BmiCategory::NORMAL],
            [24.99999, BmiCategory::NORMAL],
            [25, BmiCategory::OVERWEIGHT],
            [27, BmiCategory::OVERWEIGHT],
            [30, BmiCategory::OBESE_CLASS_I],
            [35, BmiCategory::OBESE_CLASS_II],
            [40, BmiCategory::OBESE_CLASS_III],
            [40.00001, BmiCategory::OBESE_CLASS_III],
            [41, BmiCategory::OBESE_CLASS_III],
            [4000000, BmiCategory::OBESE_CLASS_III],
        ];
    }

    /**
     * @throws Exception
     */
    #[DataProvider('bmiProvider')]
    public function test_calculate(int $weight, int $height, UnitType $type, float $bmi)
    {
        $result = app(BmiService::class)->calculate($height, $weight, $type);

        $this->assertNotEmpty($result);
        $this->assertEquals($bmi, $result);
    }

    /**
     * @throws Exception
     */
    #[DataProvider('bmiCategoryProvider')]
    public function test_get_bmi_category(float $bmi, BmiCategory $category)
    {
        $result = app(BmiService::class)->getCategoryByBMI($bmi);

        $this->assertNotEmpty($result);
        $this->assertEquals($category, $result);
    }

    // TODO: needs mock
    /* public function test_get_bmi_translation()
    {
        $service = app(BmiService::class);

        foreach (BmiCategory::cases() as $case) {
            $label = $service::getLabelByBmiCategory($case);
            $this->assertNotEmpty($label);
            $this->assertStringNotContainsString('bmi.categories.', $label);
        }
    }*/

    public function test_throws_exception_when_no_weight(): void
    {
        $this->expectException(Exception::class);
        app(BmiService::class)->calculate(10, 0);
    }

    public function test_throws_exception_when_no_height(): void
    {
        $this->expectException(Exception::class);
        app(BmiService::class)->calculate(0, 10);
    }

    public function test_throws_exception_when_no_weight_and_height(): void
    {
        $this->expectException(Exception::class);
        app(BmiService::class)->calculate(0, 0);
    }
}
