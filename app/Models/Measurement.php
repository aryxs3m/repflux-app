<?php

namespace App\Models;

use App\Models\Traits\HasTenantRelationship;
use App\Observers\MeasurementCacheObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy([MeasurementCacheObserver::class])]
class Measurement extends Model
{
    use HasFactory;
    use HasTenantRelationship;

    protected $fillable = [
        'measurement_type_id',
        'user_id',
        'measured_at',
        'value',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function measurementType(): BelongsTo
    {
        return $this->belongsTo(MeasurementType::class);
    }

    protected function casts(): array
    {
        return [
            'measured_at' => 'datetime',
        ];
    }
}
