<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Services\RawgService;
use App\Shared\Constants;
use App\Shared\Dtos\CreateListData;
use App\Shared\Dtos\RawgGameResponse;
use App\Shared\Enums\Visibility;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class ListController extends Controller
{
    public function __construct(private RawgService $rawgService)
    {
    }

    public function createListView()
    {
        return Inertia::render('CreateList', new CreateListData());
    }

    public function searchGames(Request $request)
    {
        $valid = $request->validate(["query" => "required"]);
        $games = $this->rawgService->searchGames($valid["query"]);

        $gamesToInsert = collect([]);
        foreach ($games as $game) {
            $exist = Game::whereRawgId($game->id)->count();
            if (!$exist) {
                $gamesToInsert->push([
                    "rawg_id" => $game->id,
                    "name" => $game->name,
                    "image" => $game->background_image,
                    "release_date" => $game->released
                ]);
            }
        }
        Game::insert($gamesToInsert->toArray());
        redirect()->back()->with(Constants::SEARCH_RESULTS_KEY, $games);
    }
}
