<?php

namespace App\Models;

use App\Shared\Enums\InteractionType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * 
 *
 * @property InteractionType $type
 * @property-read \App\Models\GameList|null $list
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Interaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Interaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Interaction query()
 * @mixin \Eloquent
 */
class Interaction extends Model
{
    use HasFactory;

    protected $casts = [
        'type' => InteractionType::class
    ];

    protected $fillable = [
        'type',
        'content',
        'user_id',
        'game_list_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function list(): BelongsTo
    {
        return $this->belongsTo(GameList::class);
    }
}
