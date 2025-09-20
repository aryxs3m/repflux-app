<?php

namespace App\Services\ChartBuilder;

class Dataset
{
    protected string $label;

    protected array $data = [];

    protected string $fill = 'false';

    protected string $borderColor = '';

    protected array $borderDash = [];

    protected string|bool $pointStyle = 'circle';

    public static function make(): static
    {
        return new self;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function addValue(float|int $value): static
    {
        $this->data[] = $value;

        return $this;
    }

    public function addValues(array $values): static
    {
        $this->data += $values;

        return $this;
    }

    public function setFill(string|DatasetFill $fill): static
    {
        if ($fill instanceof DatasetFill) {
            $this->fill = $fill->value;

            return $this;
        }

        $this->fill = $fill;

        return $this;
    }

    public function setBorderColor(string $borderColor): Dataset
    {
        $this->borderColor = $borderColor;

        return $this;
    }

    public function setBorderDash(array $borderDash): Dataset
    {
        $this->borderDash = $borderDash;

        return $this;
    }

    public function setPointStyle(string|DatasetPointStyle|bool $pointStyle): Dataset
    {
        if ($pointStyle instanceof DatasetPointStyle) {
            $this->pointStyle = $pointStyle->value;

            return $this;
        }

        $this->pointStyle = $pointStyle;

        return $this;
    }

    public function toArray(): array
    {
        return array_filter([
            'label' => $this->label,
            'fill' => $this->fill,
            'borderColor' => $this->borderColor,
            'borderDash' => $this->borderDash,
            'pointStyle' => $this->pointStyle,
            'data' => $this->data,
        ], fn ($item) => $item !== '');
    }
}
