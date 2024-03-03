<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Laravel\Socialite\Facades\Socialite;


class AuthController extends Controller
{
    function redirect(Request $request)
    {
        if ($request->user()) {
            return redirect("/");
        }
        return Socialite::driver('discord')->redirect();
    }

    function callback()
    {
        $discordUser = Socialite::driver('discord')->user();
        $user = User::where('email', $discordUser->getEmail())->first();

        if (!$user) {
            $user = User::create([
                'name' => $discordUser->getName(),
                'avatar' => $discordUser->getAvatar(),
                'email' => $discordUser->getEmail(),
            ]);
        }

        Auth::login($user, true);
        return redirect("/");
    }

    function logout()
    {
        Auth::logout();
        return redirect("/");
    }
}
