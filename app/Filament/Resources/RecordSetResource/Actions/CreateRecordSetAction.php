<?php

namespace App\Filament\Resources\RecordSetResource\Actions;

use App\Filament\Resources\RecordSetResource\Pages\CreateRecordSet;
use Filament\Actions\CreateAction;
use Illuminate\Contracts\Support\Htmlable;

class CreateRecordSetAction extends CreateAction
{
    public function getUrl(): ?string
    {
        return CreateRecordSet::getUrl();
    }

    public function getLabel(): string|Htmlable|null
    {
        return __('pages.record_sets.add_set');
    }
}
