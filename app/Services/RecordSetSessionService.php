<?php

namespace App\Services;

use App\Models\RecordSet;
use Carbon\Carbon;

class RecordSetSessionService
{
    public function updateLastOptions(RecordSet $recordSet): void
    {
        session()->put('last_record_type_id', $recordSet->record_type_id);
        session()->put('last_record_category_id', $recordSet->recordType->record_category_id);
        session()->put('last_set_done', $recordSet->set_done_at->toDateString());
    }

    public function getLastRecordTypeId(): ?int
    {
        return session()->get('last_record_type_id');
    }

    public function getLastRecordCategoryId(): ?int
    {
        return session()->get('last_record_category_id');
    }

    public function getLastSetDone(): ?Carbon
    {
        return session()->get('last_set_done') ? Carbon::parse(session()->get('last_set_done')) : null;
    }

    public function hasLastRecord(): bool
    {
        return ! empty($this->getLastRecordTypeId()) && ! empty($this->getLastRecordCategoryId()) && ! empty($this->getLastSetDone());
    }
}
