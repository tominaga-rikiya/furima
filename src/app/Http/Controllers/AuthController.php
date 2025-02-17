<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);


        session(['first_login' => true]);


        if ($user->profile) {
            return redirect()->route('home');
        }

        return redirect()->route('profile.edit');
    }


    public function login(LoginRequest $request)
    {
        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect()->route('home');
        }

        return back();
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
