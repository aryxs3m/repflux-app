<?php

namespace App\Models;

use App\Services\Settings\Enums\UnitType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tenant extends Model
{
    protected $fillable = [
        'name',
        'unit_type',
        'language',
    ];

    protected $casts = [
        'unit_type' => UnitType::class,
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
