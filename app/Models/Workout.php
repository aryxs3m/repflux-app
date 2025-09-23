<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property \Illuminate\Support\Carbon $workout_at
 * @property string|null $notes
 * @property int $tenant_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $calc_dominant_category Calculated on updates
 * @property float|null $calc_total_weight Calculated on updates
 * @property int|null $calc_total_reps Calculated on updates
 * @property int|null $calc_total_exercises Calculated on updates
 * @property-read \App\Models\RecordCategory|null $dominantCategory
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RecordSet> $recordSets
 * @property-read int|null $record_sets_count
 * @property-read \App\Models\Tenant|null $tenant
 *
 * @method static \Database\Factories\WorkoutFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workout newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workout newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workout query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workout whereCalcDominantCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workout whereCalcTotalExercises($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workout whereCalcTotalReps($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workout whereCalcTotalWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workout whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workout whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workout whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workout whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workout whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workout whereWorkoutAt($value)
 *
 * @mixin \Eloquent
 */
class Workout extends Model
{
    use HasFactory;

    protected $fillable = [
        'workout_at',
        'notes',
        'tenant_id',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function recordSets(): HasMany
    {
        return $this->hasMany(RecordSet::class);
    }

    public function dominantCategory(): BelongsTo
    {
        return $this->belongsTo(RecordCategory::class, 'calc_dominant_category', 'id');
    }

    protected function casts(): array
    {
        return [
            'workout_at' => 'datetime',
        ];
    }
}
