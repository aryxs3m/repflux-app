<?php

namespace App\Services\ChartBuilder;

class BaseChart
{
    protected array $datasets = [];

    protected array $labels = [];

    public static function make(): static
    {
        return new self;
    }

    public function addDataset(Dataset $dataset): self
    {
        $this->datasets[] = $dataset->toArray();

        return $this;
    }

    public function addLabels(array $labels): self
    {
        $this->labels += $labels;

        return $this;
    }

    public function addLabel(string $label): self
    {
        $this->labels[] = $label;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'datasets' => $this->datasets,
            'labels' => $this->labels,
        ];
    }
}
