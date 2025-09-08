<?php

namespace App\Models;

use App\Models\Traits\HasTenantRelationship;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RecordSet extends Model
{
    use HasTenantRelationship;

    protected $fillable = [
        'record_type_id',
        'user_id',
        'set_done_at',
    ];

    public function recordType(): BelongsTo
    {
        return $this->belongsTo(RecordType::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function records(): HasMany
    {
        return $this->hasMany(Record::class);
    }

    protected function casts(): array
    {
        return [
            'set_done_at' => 'datetime',
        ];
    }
}
