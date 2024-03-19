<?php

namespace App\Models;

use App\Shared\Enums\Visibility;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 *
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $title
 * @property string $description
 * @property bool $ranked
 * @property string $visibility
 * @property int $user_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Entry> $entires
 * @property-read int|null $entires_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|GameList newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GameList newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GameList query()
 * @method static \Illuminate\Database\Eloquent\Builder|GameList whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GameList whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GameList whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GameList whereRanked($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GameList whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GameList whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GameList whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GameList whereVisibility($value)
 * @mixin \Eloquent
 */
class GameList extends Model
{
    use HasFactory;

    protected $casts = [
        'visibility' => Visibility::class
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function entires(): HasMany
    {
        return $this->hasMany(Entry::class);
    }
}
