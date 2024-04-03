<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;


class AuthController extends Controller
{
    function redirect()
    {
        if (Auth::user()) {
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
