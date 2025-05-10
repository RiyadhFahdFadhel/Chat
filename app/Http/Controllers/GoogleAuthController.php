<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        // return Socialite::driver('google')->stateless()->redirect();
        return Socialite::driver('google')->redirect(); // ✅ no stateless here

    }

    public function callback()
    {
        // $googleUser = Socialite::driver('google')->stateless()->user();
        
        $googleUser = Socialite::driver('google')->user();
        
        $user = User::updateOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                
                ]
            );

        Auth::login($user);

        return redirect('/users');

    }
}
