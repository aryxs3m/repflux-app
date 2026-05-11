<?php

namespace App\Models;

use App\Services\Settings\Enums\UnitType;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property UnitType $unit_type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read TenantUser|null $pivot
 * @property-read Collection<int, User> $users
 * @property-read int|null $users_count
 *
 * @method static \Database\Factories\TenantFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tenant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tenant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tenant query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tenant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tenant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tenant whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tenant whereUnitType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tenant whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Tenant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'unit_type',
    ];

    protected $casts = [
        'unit_type' => UnitType::class,
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->using(TenantUser::class)
            ->withPivot('is_admin');
    }
}
