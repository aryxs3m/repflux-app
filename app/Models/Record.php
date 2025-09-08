<?php

namespace App\Models;

use App\Models\Traits\HasTenantRelationship;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Record extends Model
{
    use HasTenantRelationship;

    protected $fillable = [
        'record_set_id',
        'repeat_index',
        'repeat_count',
        'weight',
    ];

    protected $appends = [
        'weight_with_base',
    ];

    public function recordSet(): BelongsTo
    {
        return $this->belongsTo(RecordSet::class);
    }

    public function weightWithBase(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->weight + $this->recordSet->recordType->base_weight,
        );
    }
}
