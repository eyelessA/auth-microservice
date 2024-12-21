<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class CallbackGoogleService
{
    public function callbackGoogle(): RedirectResponse|string|null
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::query()->where('google_id', $googleUser->id)->first();

            if ($user) {
                Auth::login($user);
                return redirect()->route('dashboard');
            } else {
                $userData = User::query()->create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'email_verified_at' => Carbon::now(),
                    'password' => Hash::make(Str::random(16)),
                    'google_id' => $googleUser->id,
                ]);
                if ($userData) {
                    Auth::login($userData);
                    return redirect()->route('dashboard');
                }
            }
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
        return null;
    }
}
