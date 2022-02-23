<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function redirect()
    {
        return \Socialite::driver('auth0')->redirect();
    }

    public function callback()
    {
        $auth0User = \Socialite::driver('auth0')->user();

        $user = User::where('auth0_id', $auth0User->id)->first();

        if (!$user) {
            $user = User::create([
                'name' => $auth0User->name,
                'email' => $auth0User->email,
                'auth0_id' => $auth0User->id,
            ]);
        }

        auth()->login($user);

        return redirect()->to('/');
    }
}
