<?php

namespace Tests\Unit\Services;

use App\Services\ChartBuilder\BaseChart;
use App\Services\ChartBuilder\Dataset;
use App\Services\ChartBuilder\DatasetFill;
use App\Services\ChartBuilder\DatasetPointStyle;
use Exception;
use PHPUnit\Framework\TestCase;

class ChartBuilderTest extends TestCase
{
    public function test_can_create_empty_chart(): void
    {
        $baseChart = BaseChart::make();

        $this->assertNotNull($baseChart);
        $this->assertArrayHasKey('labels', $baseChart->toArray());
        $this->assertArrayHasKey('datasets', $baseChart->toArray());
    }

    public function test_can_add_label(): void
    {
        $baseChart = BaseChart::make();
        $baseChart->addLabel('test');

        $this->assertContains('test', $baseChart->toArray()['labels']);

        $baseChart->addLabel('test2');
        $this->assertContains('test', $baseChart->toArray()['labels']);
        $this->assertContains('test2', $baseChart->toArray()['labels']);
    }

    public function test_can_add_labels(): void
    {
        $baseChart = BaseChart::make();
        $baseChart->addLabels(['test']);

        $this->assertContains('test', $baseChart->toArray()['labels']);

        $baseChart->addLabels(['test2', 'test3']);
        $this->assertContains('test', $baseChart->toArray()['labels']);
        $this->assertContains('test2', $baseChart->toArray()['labels']);
        $this->assertContains('test3', $baseChart->toArray()['labels']);
    }

    public function test_cant_create_empty_dataset()
    {
        $dataset = Dataset::make();
        $this->assertNotEmpty($dataset);

        $this->expectException(Exception::class);
        $this->assertIsArray($dataset->toArray());
    }

    /**
     * @throws Exception
     */
    public function test_can_create_empty_dataset_with_label()
    {
        $dataset = Dataset::make()
            ->setLabel('Test');
        $this->assertNotEmpty($dataset);
        $this->assertIsArray($dataset->toArray());
    }

    /**
     * @throws Exception
     */
    public function test_can_create_simple_dataset_with_label()
    {
        $dataset = Dataset::make()
            ->setLabel('Test')
            ->addValue(10)
            ->addValues([20, 30]);

        $array = $dataset->toArray();

        $this->assertNotEmpty($dataset);
        $this->assertIsArray($array);
        $this->assertEquals('Test', $array['label']);
        $this->assertEquals([10, 20, 30], $array['data']);
    }

    /**
     * @throws Exception
     */
    public function test_can_set_dataset_customizations()
    {
        $dataset = Dataset::make()
            ->setLabel('Test')
            ->setFill(DatasetFill::START)
            ->setBorderDash([1, 2])
            ->setBorderColor('#ffd500')
            ->setPointStyle(DatasetPointStyle::CIRCLE);

        $array = $dataset->toArray();

        $this->assertEquals('start', $array['fill']);
        $this->assertEquals([1, 2], $array['borderDash']);
        $this->assertEquals('#ffd500', $array['borderColor']);
        $this->assertEquals('circle', $array['pointStyle']);
    }

    /**
     * @throws Exception
     */
    public function test_can_set_dataset_string_customizations()
    {
        $dataset = Dataset::make()
            ->setLabel('Test')
            ->setFill('custom_fill')
            ->setPointStyle('custom_point_style');

        $array = $dataset->toArray();

        $this->assertEquals('custom_fill', $array['fill']);
        $this->assertEquals('custom_point_style', $array['pointStyle']);
    }

    public function test_can_create_chart_with_single_dataset(): void
    {
        $baseChart = BaseChart::make()
            ->addDataset(Dataset::make()->setLabel('Test')->addValue(10));

        $this->assertNotNull($baseChart);
        $this->assertArrayHasKey('labels', $baseChart->toArray());
        $this->assertArrayHasKey('datasets', $baseChart->toArray());
        $this->assertCount(1, $baseChart->toArray()['datasets']);
    }

    public function test_can_create_chart_with_two_datasets(): void
    {
        $baseChart = BaseChart::make()
            ->addDataset(Dataset::make()->setLabel('Test 1')->addValue(10))
            ->addDataset(Dataset::make()->setLabel('Test 2')->addValue(10));

        $this->assertNotNull($baseChart);
        $this->assertArrayHasKey('labels', $baseChart->toArray());
        $this->assertArrayHasKey('datasets', $baseChart->toArray());
        $this->assertCount(2, $baseChart->toArray()['datasets']);
    }
}
