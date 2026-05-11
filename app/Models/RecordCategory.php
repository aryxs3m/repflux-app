<?php

namespace App\Models;

use App\Models\Traits\HasTenantRelationship;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $tenant_id
 * @property-read Collection<int, RecordType> $recordTypes
 * @property-read int|null $record_types_count
 * @property-read Tenant|null $tenant
 * @property-read Collection<int, Workout> $workouts
 * @property-read int|null $workouts_count
 *
 * @method static \Database\Factories\RecordCategoryFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordCategory whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordCategory whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class RecordCategory extends Model
{
    use HasFactory;
    use HasTenantRelationship;

    protected $fillable = [
        'name',
    ];

    public function recordTypes(): HasMany
    {
        return $this->hasMany(RecordType::class);
    }

    public function workouts(): HasMany
    {
        return $this->hasMany(Workout::class, 'calc_dominant_category');
    }
}
