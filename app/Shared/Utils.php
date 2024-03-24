<?php

namespace App\Shared;

use App\Shared\Dtos\RawgGameResponse;

class Utils
{
    public static function formatGameName(RawgGameResponse $game): string
    {
        if ($game->released && !stripos("(", $game->name)) {
            return "{$game->name} - " . substr($game->released, 0, 4);
        }
        return $game->name;
    }
}
