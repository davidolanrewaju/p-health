<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
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
    try {
        $googleUser = Socialite::driver('google')->user();

        if (Auth::check()) {
            $user = Auth::user();
            User::where('id', $user->id)->update([
                'google_access_token' => $googleUser->token,
                'google_refresh_token' => $googleUser->refreshToken,
            ]);
            return redirect()->route('dashboard')->with('success', 'Google Calendar connected successfully!');
        }

        $user = User::updateOrCreate([
            'email' => $googleUser->email,
        ], [
            'name' => $googleUser->name,
            'google_access_token' => $googleUser->token,
            'google_refresh_token' => $googleUser->refreshToken,
            'password' => bcrypt(Str::random(16)), // Add a random password for new users
        ]);

        Auth::login($user);
        return redirect()->route('dashboard');

    } catch (\Exception $e) {
        // Log the error and redirect with an error message
        Log::error('Google OAuth Error: ' . $e->getMessage());
        return redirect()->route('login')->with('error', 'Unable to authenticate with Google. Please try again.');
    }
}
}
