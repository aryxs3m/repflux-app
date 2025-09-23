<?php

namespace App\Models;

use App\Filament\Resources\RecordTypeResource\ExerciseType;
use App\Models\Traits\HasTenantRelationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $name
 * @property int $record_category_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property float $base_weight
 * @property int $tenant_id
 * @property string|null $notes
 * @property string $exercise_type
 * @property array<array-key, mixed>|null $cardio_measurements
 * @property-read \App\Models\RecordCategory|null $recordCategory
 * @property-read \App\Models\Tenant|null $tenant
 *
 * @method static \Database\Factories\RecordTypeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordType whereBaseWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordType whereCardioMeasurements($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordType whereExerciseType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordType whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordType whereRecordCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordType whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecordType whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class RecordType extends Model
{
    use HasFactory;
    use HasTenantRelationship;

    protected $fillable = [
        'name',
        'record_category_id',
        'base_weight',
        'notes',
        'exercise_type',
        'cardio_measurements',
    ];

    protected function casts(): array
    {
        return [
            'cardio_measurements' => 'json',
            'exercise_type' => ExerciseType::class,
        ];
    }

    public function recordCategory(): BelongsTo
    {
        return $this->belongsTo(RecordCategory::class);
    }
}
