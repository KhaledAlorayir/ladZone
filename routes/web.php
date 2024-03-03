<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
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
    $name = $request->query("name") ?? "khaled";
    return Inertia::render("Home", ["name" => $name]);
});


Route::get("/auth/discord", function (Request $request) {
    return Socialite::driver('discord')->redirect();
});

Route::get("/auth/discord/callback", function (Request $request) {
    $user = Socialite::driver('discord')->user();
    dd($user);
});
