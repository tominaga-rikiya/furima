<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest; 
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // 会員登録
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // ユーザーをログイン状態に
        Auth::login($user);

        if ($user->isFirstTime()) {
    
            return redirect()->route('profile.edit');
        }

        return redirect()->route('home');  // ホームページにリダイレクト
    }

    public function login(LoginRequest $request)
    {
        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect()->route('home');  // ログイン成功後にリダイレクト
        }

        return back()->withErrors([
            'email' => 'ログイン情報が登録されていません',
        ]);
    }

    // ログアウト
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
