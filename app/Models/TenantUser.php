<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class TenantUser extends Pivot
{
    public $timestamps = false;

    protected $fillable = [
        'user_id', 'tenant_id', 'is_admin', 'created_at',
    ];
}
