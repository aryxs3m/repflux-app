<?php

namespace App\Models;

use App\Models\Traits\HasTenantRelationship;
use App\Observers\WorkoutUpdaterObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $record_set_id
 * @property int $repeat_index
 * @property int $repeat_count
 * @property float|null $weight
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\RecordSet|null $recordSet
 * @property-read \App\Models\Tenant|null $tenant
 * @property-read mixed $weight_with_base
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Record newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Record newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Record query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Record whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Record whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Record whereRecordSetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Record whereRepeatCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Record whereRepeatIndex($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Record whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Record whereWeight($value)
 *
 * @mixin \Eloquent
 */
#[ObservedBy([WorkoutUpdaterObserver::class])]
class Record extends Model
{
    use HasTenantRelationship;

    protected $fillable = [
        'record_set_id',
        'repeat_index',
        'repeat_count',
        'weight',
    ];

    protected $appends = [
        'weight_with_base',
    ];

    public function recordSet(): BelongsTo
    {
        return $this->belongsTo(RecordSet::class);
    }

    public function weightWithBase(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->weight + $this->recordSet->recordType->base_weight,
        );
    }
}
