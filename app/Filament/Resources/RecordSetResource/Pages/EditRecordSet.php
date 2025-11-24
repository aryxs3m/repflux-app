<?php

namespace App\Filament\Resources\RecordSetResource\Pages;

use App\Filament\Actions\OpenWorkoutAction;
use App\Filament\Resources\RecordSetResource;
use App\Filament\Resources\RecordSetResource\Actions\CreateRecordSetAction;
use App\Filament\Resources\RecordSetResource\Actions\ReplicateRecordSetAction;
use App\Models\RecordSet;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;

/**
 * @property RecordSet $record
 */
class EditRecordSet extends EditRecord
{
    protected static string $resource = RecordSetResource::class;

    public function getTitle(): string|Htmlable
    {
        return __('pages.record_sets.edit_title');
    }

    public function getSubheading(): string|Htmlable|null
    {
        return sprintf(
            '%s, %s (%s)',
            $this->record->recordType->name,
            $this->record->set_done_at->diffForHumans(),
            $this->record->user->name
        );
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
