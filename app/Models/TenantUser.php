<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @property int $user_id
 * @property int $tenant_id
 * @property string $created_at
 * @property int $is_admin
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TenantUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TenantUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TenantUser query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TenantUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TenantUser whereIsAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TenantUser whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TenantUser whereUserId($value)
 *
 * @mixin \Eloquent
 */
class TenantUser extends Pivot
{
    public $timestamps = false;

    protected $fillable = [
        'user_id', 'tenant_id', 'is_admin', 'created_at',
    ];
}
