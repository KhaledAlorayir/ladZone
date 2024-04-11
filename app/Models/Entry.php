<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * 
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $note
 * @property int $game_list_id
 * @property int $game_id
 * @property-read \App\Models\Game $game
 * @property-read \App\Models\GameList|null $list
 * @method static \Illuminate\Database\Eloquent\Builder|Entry newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Entry newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Entry query()
 * @method static \Illuminate\Database\Eloquent\Builder|Entry whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry whereGameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry whereGameListId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Entry whereUpdatedAt($value)
 * @property int|null $rank
 * @method static \Illuminate\Database\Eloquent\Builder|Entry whereRank($value)
 * @mixin \Eloquent
 */
class Entry extends Model
{
    use HasFactory;

    protected $fillable = [
        'note',
        'game_id',
        'rank'
    ];

    public function list(): BelongsTo
    {
        return $this->belongsTo(GameList::class);
    }

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }
}
