<?php

namespace App\Models;

use App\Models\Traits\HasTenantRelationship;
use App\Observers\MeasurementTypeCacheObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([MeasurementTypeCacheObserver::class])]
/**
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $tenant_id
 * @property-read \App\Models\Tenant|null $tenant
 *
 * @method static \Database\Factories\MeasurementTypeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeasurementType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeasurementType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeasurementType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeasurementType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeasurementType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeasurementType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeasurementType whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeasurementType whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class MeasurementType extends Model
{
    use HasFactory;
    use HasTenantRelationship;

    protected $fillable = [
        'name',
    ];
}
