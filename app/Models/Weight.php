<?php

namespace App\Models;

use App\Models\Traits\HasTenantRelationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Weight extends Model
{
    use HasFactory;
    use HasTenantRelationship;

    protected $fillable = [
        'weight',
        'user_id',
        'measured_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function casts(): array
    {
        return [
            'measured_at' => 'datetime',
        ];
    }
}
