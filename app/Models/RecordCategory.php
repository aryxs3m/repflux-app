<?php

namespace App\Models;

use App\Models\Traits\HasTenantRelationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $tenant_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RecordType> $recordTypes
 * @property-read int|null $record_types_count
 * @property-read \App\Models\Tenant|null $tenant
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Workout> $workouts
 * @property-read int|null $workouts_count
 * @method static \Database\Factories\RecordCategoryFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordCategory whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordCategory whereUpdatedAt($value)
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
