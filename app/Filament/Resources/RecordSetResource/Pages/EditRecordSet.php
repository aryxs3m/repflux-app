<?php

namespace App\Filament\Resources\RecordSetResource\Pages;

use App\Filament\Resources\RecordSetResource;
use App\Filament\Resources\RecordSetResource\Actions\ReplicateRecordSetAction;
use Filament\Actions\ActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;

class EditRecordSet extends EditRecord
{
    protected static string $resource = RecordSetResource::class;

    public function getTitle(): string|Htmlable
    {
        return __('pages.record_sets.edit_title');
    }

    protected function getHeaderActions(): array
    {
        return [
            ActionGroup::make([
                CreateAction::make(),
                ReplicateRecordSetAction::make(),
            ])->buttonGroup(),
            DeleteAction::make(),
        ];
    }
}
