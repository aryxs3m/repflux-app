<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Record extends Model
{
    protected $fillable = [
        'record_set_id',
        'repeat_index',
        'repeat_count',
        'weight',
    ];

    public function recordSet(): BelongsTo
    {
        return $this->belongsTo(RecordSet::class);
    }
}
