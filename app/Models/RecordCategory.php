<?php

namespace App\Models;

use App\Models\Traits\HasTenantRelationship;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RecordCategory extends Model
{
    use HasTenantRelationship;

    protected $fillable = [
        'name',
    ];

    public function recordTypes(): HasMany
    {
        return $this->hasMany(RecordType::class);
    }
}
