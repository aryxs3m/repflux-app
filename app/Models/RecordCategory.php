<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RecordCategory extends Model
{
    protected $fillable = [
        'name',
    ];

    public function recordTypes(): HasMany
    {
        return $this->hasMany(RecordType::class);
    }
}
