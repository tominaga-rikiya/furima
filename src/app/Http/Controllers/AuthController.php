<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth; // 追加

class AuthController extends Controller
{
    // 会員登録フォームを表示
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // 会員登録処理
    public function register(RegisterRequest $request)
    {
        // 入力値の検証
        $validatedData = $request->validated();

        // ユーザーの作成
        $user = $this->create($request->all());

        // ユーザー登録後にログインさせる
        auth()->login($user);

        // ダッシュボードなどにリダイレクト（例えば 'dashboard'）
        return redirect()->route('login'); // ここを 'login' から 'dashboard' に変更することもできます
    }

    // 入力値のバリデーション
    protected function validator(array $data)
    {
       
    }

    // ユーザー作成処理
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    // ログインフォームを表示
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // ログイン処理
    public function login(Request $request)
    {
        // バリデーション
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 認証処理
        if (Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']])) {
            // ログイン成功
            return redirect()->intended('/home');
        }

        // ログイン失敗
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
}

