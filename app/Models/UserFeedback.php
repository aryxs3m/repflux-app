<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $type
 * @property string $message
 * @property int $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User|null $user
 *
 * @method static \Database\Factories\UserFeedbackFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFeedback newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFeedback newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFeedback query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFeedback whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFeedback whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFeedback whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFeedback whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFeedback whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFeedback whereUserId($value)
 *
 * @mixin \Eloquent
 */
class UserFeedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'message',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
