<?php

namespace App\Filament\Fields;

use Closure;
use Filament\Forms\Components\Field;

/**
 * A simple client-based stopwatch. It is basically a HTML5 "time" component, the data is transformed
 * from this time component to elapsed milliseconds.
 */
class Stopwatch extends Field
{
    protected string $view = 'filament.fields.stopwatch';

    protected bool|Closure $isLabelHidden = true;

    protected mixed $defaultState = 0;

    protected bool $hasDefaultState = true;

    protected function setUp(): void
    {
        parent::setUp();

        $this->stateCast(new StopwatchCast);
    }
}
