<?php

namespace App\Http\Controllers;

use App\Services\RawgService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ListController extends Controller
{
    public function __construct(private RawgService $rawgService)
    {
    }
    public function searchGames(Request $request)
    {
        $this->rawgService->myFunction();
        // Log::info($request->query("query"));
        return redirect("/");
    }
}
