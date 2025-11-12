<?php

namespace App\Filament\Resources\RecordSetResource\Pages;

use App\Filament\AbstractCreateRecord;
use App\Filament\Resources\RecordSetResource;
use App\Models\RecordSet;
use App\Services\RecordSetSessionService;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

class CreateRecordSet extends AbstractCreateRecord
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

    protected function getRedirectUrl(): string
    {
        $resource = static::getResource();

        if ($resource::hasPage('edit') && $resource::canEdit($this->getRecord())) {
            return $this->getResourceUrl('edit', $this->getRedirectUrlParameters());
        }

        return parent::getRedirectUrl();
    }

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
