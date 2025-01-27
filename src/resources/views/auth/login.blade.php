@extends('layouts.app')

@section('content')
<div class="login-form">
    <h2>ログイン</h2>
    <form action="{{ route('login') }}" method="POST">
        @csrf
        <div class="register-form__group">
        <label class="register-form__label" for="email">ユーザー名/メールアドレス</label>
        <input class="register-form__input" type="email" name="email" id="email" value="{{ old('email') }}">
        <p class="register-form__error-message">
          @error('email')
          {{ $message }}
          @enderror
        </p>
      </div>
       <div class="register-form__group">
        <label class="register-form__label" for="password">パスワード</label>
        <input class="register-form__input" type="password" name="password" id="password" >
        <p class="register-form__error-message">
          @error('password')
          {{ $message }}
          @enderror
        </p>
      </div>
            <button type="submit">ログイン</button>
        </div>
    </form>
    <a href="{{ route('register') }}">会員登録はこちら</a>
</div>
@endsection