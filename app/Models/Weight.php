<?php

namespace App\Models;

use App\Models\Traits\HasTenantRelationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property float $weight
 * @property int $user_id
 * @property Carbon $measured_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $tenant_id
 * @property-read Tenant|null $tenant
 * @property-read User|null $user
 *
 * @method static \Database\Factories\WeightFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Weight newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Weight newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Weight query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Weight whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Weight whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Weight whereMeasuredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Weight whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Weight whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Weight whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Weight whereWeight($value)
 *
 * @mixin \Eloquent
 */
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
