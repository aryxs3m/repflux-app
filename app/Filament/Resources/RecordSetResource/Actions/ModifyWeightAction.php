<?php

namespace App\Filament\Resources\RecordSetResource\Actions;

use Filament\Actions\Action;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;

class ModifyWeightAction extends Action
{
    protected float $weight;

    public function setWeight(float $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public static function makeWithWeight(float $weight)
    {
        $label = $weight;
        $icon = Heroicon::MinusCircle;
        if ($weight > 0) {
            $label = "+$weight";
            $icon = Heroicon::PlusCircle;
        }

        return self::make($weight)
            ->setWeight($weight)
            ->label($label)
            ->icon($icon);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->color(Color::Gray)
            ->action(function ($state, Set $set) {
                self::addWeightToRecords($state, $set, $this->weight);
            });
    }

    protected static function addWeightToRecords($state, Set $set, float $weightIncrease): void
    {
        $records = array_map(function ($record) use ($weightIncrease) {
            return [
                'repeat_count' => $record['repeat_count'],
                'weight' => $record['weight'] + $weightIncrease,
            ];
        }, $state['records']);

        $set('records', $records);
    }
}
