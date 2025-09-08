<?php

namespace App\Models;

use App\Models\Traits\HasTenantRelationship;
use App\Observers\MeasurementTypeCacheObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([MeasurementTypeCacheObserver::class])]
class MeasurementType extends Model
{
    use HasTenantRelationship;

    protected $fillable = [
        'name',
    ];
}
