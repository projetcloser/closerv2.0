<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if (!$user->is_active) {
                Auth::logout();
                return redirect()->route('login')->withErrors('Votre compte est désactivé.');
            }

            if ($user->hasRole('administrateur')) {
                return redirect()->route('home')->with('message', 'Bonjour administrateur');
            } elseif ($user->hasRole('membre')) {
                return redirect()->route('home')->with('message', 'Bonjour membre');
            } else {
                return redirect()->route('home');
            }
        }

        return redirect()->route('login')->withErrors('Identifiants incorrects.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
