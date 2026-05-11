<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $hash
 * @property int $tenant_id
 * @property Carbon $expires_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Tenant|null $tenant
 *
 * @method static \Database\Factories\InviteFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invite newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invite newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invite query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invite whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invite whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invite whereHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invite whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invite whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invite whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Invite extends Model
{
    use HasFactory;

    protected $fillable = [
        'hash',
        'tenant_id',
        'expires_at',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
        ];
    }
}
