<?php

namespace App\Services;

use Illuminate\Support\Facades\App;
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
        // error handling, type response, validaite empty string in controller use response and  show at FE
        $response = Http::get($this->BASE_PATH, array_merge($this->BASE_QUERY_PARAMS, ["search" => $query]));
        dd($response->json());
    }
}
