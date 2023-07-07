<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AuthController extends Controller
{
    /**
     * Redirect the user to the Steam authentication page.
     */
    public function login(): RedirectResponse
    {
        return Socialite::driver('steam')->redirect();
    }

    /**
     * Log the user out of the application.
     */
    public function logout(): Application|Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        Auth::logout();

        return redirect('/');
    }

    /**
     * Handle the callback from the Steam authentication provider.
     */
    public function callback(): Application|Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $steamUser = Socialite::driver('steam')->user();

        $user = User::updateOrCreate(
            [
                'steam_id' => $steamUser->getId(),
            ],
            [
                'name' => $steamUser->getNickname(),
                'email' => $steamUser->getEmail(),
                'avatar' => $steamUser->getAvatar(),
            ]);

        if ($user->roles->isEmpty()) {
            $user->assignRole('user');
        }

        Auth::login($user);

        return redirect('/');
    }
}
