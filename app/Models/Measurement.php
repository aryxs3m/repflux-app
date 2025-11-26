<?php

namespace App\Models;

use App\Models\Traits\HasTenantRelationship;
use App\Observers\MeasurementCacheObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy([MeasurementCacheObserver::class])]
/**
 * @property int $id
 * @property int $measurement_type_id
 * @property \Illuminate\Support\Carbon $measured_at
 * @property int $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $user_id
 * @property int $tenant_id
 * @property-read \App\Models\MeasurementType|null $measurementType
 * @property-read \App\Models\Tenant|null $tenant
 * @property-read \App\Models\User|null $user
 *
 * @method static \Database\Factories\MeasurementFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Measurement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Measurement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Measurement query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Measurement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Measurement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Measurement whereMeasuredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Measurement whereMeasurementTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Measurement whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Measurement whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Measurement whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Measurement whereValue($value)
 *
 * @mixin \Eloquent
 */
class Measurement extends Model
{
    use HasFactory;
    use HasTenantRelationship;

    protected $fillable = [
        'created_at',
        'updated_at',
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
