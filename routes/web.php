<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ListController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function (Request $request) {
    return Inertia::render("Home");
});

Route::prefix("user")->group(function () {
    Route::get("/{user}", [UserController::class, "userProfile"]);
});

Route::prefix("list")->group(function () {
    Route::post("/create-list", [ListController::class, "createList"])->middleware("auth");
    Route::get("/create-list", [ListController::class, "createListView"])->middleware("auth");
    Route::get("/search-games", [ListController::class, "searchGames"])->middleware("auth");
});

Route::prefix('auth')->group(function () {
    Route::get('/discord/redirect', [AuthController::class, 'redirect'])->name("login");
    Route::get('/discord/callback', [AuthController::class, 'callback']);
    Route::get('/logout', [AuthController::class, 'logout'])->middleware("auth");
});
