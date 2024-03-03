<?php

use App\Http\Controllers\AuthController;
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
    Log::info("hello world");
    $name = $request->user()->name ?? "not auth";
    return Inertia::render("Home", ["name" => $name]);
});

Route::prefix('auth')->group(function () {
    Route::get('/discord/redirect', [AuthController::class, 'redirect']);
    Route::get('/discord/callback', [AuthController::class, 'callback']);
    Route::get('/logout', [AuthController::class, 'logout']);
});
