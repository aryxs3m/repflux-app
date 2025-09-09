<?php

namespace App\Filament\Resources\RecordSetResource\Pages;

use App\Filament\Resources\RecordSetResource;
use App\Models\RecordSet;
use App\Services\RecordSetSessionService;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

class CreateRecordSet extends CreateRecord
{
    protected static string $resource = RecordSetResource::class;

    public function getTitle(): string|Htmlable
    {
        return __('pages.record_sets.create_title');
    }

    protected function handleRecordCreation(array $data): Model
    {
        /** @var Model|RecordSet $recordSet */
        $recordSet = parent::handleRecordCreation($data);

        app(RecordSetSessionService::class)->updateLastOptions($recordSet);

        return $recordSet;
    }

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
