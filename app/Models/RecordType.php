<?php

namespace App\Models;

use App\Models\Traits\HasTenantRelationship;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RecordType extends Model
{
    use HasTenantRelationship;

    protected $fillable = [
        'name',
        'record_category_id',
        'base_weight',
        'notes',
    ];

    public function recordCategory(): BelongsTo
    {
        return $this->belongsTo(RecordCategory::class);
    }
}
