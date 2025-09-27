<?php

namespace App\Models;

use App\Models\Traits\HasTenantRelationship;
use App\Observers\WorkoutGeneratorObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy([WorkoutGeneratorObserver::class])]
/**
 * @property int $id
 * @property int $record_type_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon $set_done_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $tenant_id
 * @property int|null $workout_id
 * @property int|null $cardio_measurement_calories
 * @property int|null $cardio_measurement_time
 * @property int|null $cardio_measurement_distance
 * @property int|null $cardio_measurement_speed_distance
 * @property int|null $cardio_measurement_speed_rotation
 * @property int|null $cardio_measurement_climbed
 * @property int|null $cardio_measurement_heart_rate
 * @property-read \App\Models\RecordType|null $recordType
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Record> $records
 * @property-read int|null $records_count
 * @property-read \App\Models\Tenant|null $tenant
 * @property-read \App\Models\User|null $user
 * @property-read \App\Models\Workout|null $workout
 *
 * @method static \Database\Factories\RecordSetFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordSet newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordSet newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordSet query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordSet whereCardioMeasurementCalories($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordSet whereCardioMeasurementClimbed($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordSet whereCardioMeasurementDistance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordSet whereCardioMeasurementHeartRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordSet whereCardioMeasurementSpeedDistance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordSet whereCardioMeasurementSpeedRotation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordSet whereCardioMeasurementTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordSet whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordSet whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordSet whereRecordTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordSet whereSetDoneAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordSet whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordSet whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordSet whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordSet whereWorkoutId($value)
 *
 * @mixin \Eloquent
 */
class RecordSet extends Model
{
    use HasFactory;
    use HasTenantRelationship;

    protected $fillable = [
        'record_type_id',
        'user_id',
        'set_done_at',
        'workout_id',
        'cardio_measurement_calories',
        'cardio_measurement_time',
        'cardio_measurement_distance',
        'cardio_measurement_speed_distance',
        'cardio_measurement_speed_rotation',
        'cardio_measurement_climbed',
        'cardio_measurement_heart_rate',
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

    public function workout(): BelongsTo
    {
        return $this->belongsTo(Workout::class);
    }

    protected function casts(): array
    {
        return [
            'set_done_at' => 'datetime',
        ];
    }
}
