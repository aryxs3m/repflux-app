<?php

namespace App\Filament\Actions;

use App\Filament\Resources\RecordSetResource\Pages\CreateRecordSet;
use App\Models\RecordType;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;

/**
 * @method RecordType getRecord(bool $withDefault = true)
 */
class NewRecordSetAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'new-record-set';
    }

    public function getLabel(): string|Htmlable|null
    {
        return __('pages.record_sets.add_set');
    }

    public function getIcon(BackedEnum|string|null $default = null): string|BackedEnum|Htmlable|null
    {
        return Heroicon::OutlinedPlusCircle;
    }

    public function getUrl(): ?string
    {
        $type = $this->getRecord();

        return CreateRecordSet::getUrl([
            'category_id' => $type->record_category_id,
            'type_id' => $type->id,
        ]);
    }

    public function getColor(): string|array|null
    {
        return 'success';
    }
}
