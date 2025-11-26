<?php

namespace App\Filament\Resources\MeasurementResource\Widgets;

use Filament\Widgets\Widget;

class MeasurementWidget extends Widget
{
    protected ?string $pollingInterval = null;

    protected int|string|array $columnSpan = 'full';

    protected string $view = 'filament.resources.measurement-resource.widgets.measurement-widget';
}
