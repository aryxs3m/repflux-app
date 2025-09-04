<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RecordType extends Model
{
    protected $fillable = [
        'name',
        'record_category_id',
    ];

    public function recordCategory(): BelongsTo
    {
        return $this->belongsTo(RecordCategory::class);
    }
}
