<?php

namespace App\Services\Data;

use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum BRICategory: string implements HasLabel {
    case LEAN = 'lean';
    case NORMAL_LEAN = 'normal_lean';
    case NORMAL = 'normal';
    case OVERWEIGHT = 'overweight';
    case ROUND_HIGH_RISK = 'round_high_risk';

    public function getLabel(): string|Htmlable|null
    {
        return __(sprintf('bri.categories.%s', $this->value));
    }
}
