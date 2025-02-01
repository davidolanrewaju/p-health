<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->scopes(['https://www.googleapis.com/auth/calendar', 'openid', 'profile', 'email'])
            ->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->user();

        if (Auth::check()) {
            $user = Auth::user()->id;
            $user = User::find($user);

            $user->update([
                'google_access_token' => $googleUser->token,
                'google_refresh_token' => $googleUser->refreshToken,
            ]);
            return redirect()->route('medication')->with('success', 'Google Calendar connected successfully!');
        }

        $user = User::updateOrCreate([
            'email' => $googleUser->email,
        ], [
            'name' => $googleUser->name,
            'google_access_token' => $googleUser->token,
            'google_refresh_token' => $googleUser->refreshToken,
            'calendar_connected' => true
        ]);

        Auth::login($user);
        return redirect()->route('dashboard');
    }
}
