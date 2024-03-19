<?php

namespace App\Services;

use App\Shared\Constants;
use App\Shared\Dtos\RawgGameResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RawgService
{
    private string $BASE_PATH = "https://api.rawg.io/api/games";
    private array $BASE_QUERY_PARAMS = [];

    public function __construct()
    {
        $this->BASE_QUERY_PARAMS["key"] = env("RAWG_API_KEY");
    }

    public function searchGames(string $query)
    {
        return Cache::remember("SEARCH_GAMES_" . strtolower($query), Constants::GAMES_CACHE_TTL_IN_SECONDS, function () use ($query) {
            $games = Http::get($this->BASE_PATH, array_merge($this->BASE_QUERY_PARAMS, ["search" => $query]))->throw()->json()["results"];
            return RawgGameResponse::collect($games);
        });
    }
}
