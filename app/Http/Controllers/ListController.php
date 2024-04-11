<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\GameList;
use App\Services\RawgService;
use App\Shared\Constants;
use App\Shared\Dtos\CreateListData;
use App\Shared\Dtos\CreateListRequest;
use App\Shared\Dtos\ListEntry;
use App\Shared\Utils;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use PhpParser\Node\Expr\List_;

class ListController extends Controller
{
    public function __construct(private RawgService $rawgService)
    {
    }

    public function createListView()
    {
        return Inertia::render('CreateList', new CreateListData());
    }

    public function createList(CreateListRequest $request)
    {

        if (GameList::whereUserId(Auth::id())->whereTitle($request->title)->exists()) {
            abort(400, "list name already used");
        }

        $selectedGames = collect($request->selectedGames);
        $games = collect(Game::whereIn('rawg_id',  $selectedGames->map(fn ($value) => $value->id)->toArray())->get());

        if ($games->count() !== $selectedGames->count()) {
            abort(400, "one or more games don't exist");
        }

        $gamesGroupedByRawgId = $games->groupBy('rawg_id');

        GameList::create(
            array_merge($request->except('selectedGames')->toArray(), ['user_id' => Auth::id()])
        )->entires()->createMany(
            $selectedGames->map(fn (ListEntry $value) => [
                'note' => $value->note,
                'game_id' => $gamesGroupedByRawgId[$value->id][0]->id,
                'rank' => $value->rank
            ])
        );;
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
            $game->name = Utils::formatGameName($game);
        }
        Game::insert($gamesToInsert->toArray());
        redirect()->back()->with(Constants::SEARCH_RESULTS_KEY, $games);
    }
}
