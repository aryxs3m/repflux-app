<?php

namespace App\Filament\Resources\RecordSetResource\Pages;

use App\Filament\Resources\RecordSetResource;
use App\Filament\Resources\RecordSetResource\Actions\CreateRecordSetAction;
use App\Filament\Actions\OpenWorkoutAction;
use App\Filament\Resources\RecordSetResource\Actions\ReplicateRecordSetAction;
use Filament\Actions\ActionGroup;
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
                CreateRecordSetAction::make(),
                ReplicateRecordSetAction::make(),
            ])->buttonGroup(),
            OpenWorkoutAction::make(),
            DeleteAction::make(),
        ];
    }
}
