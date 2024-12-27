@extends('layouts.app')

@section('content')
<div class="login-form">
    <h2>ログイン</h2>
    <form method="POST" action="{{ route('login') }}">
        @csrf
         <div class="register-form__group">
        <label class="register-form__label" for="name">ユーザー名/メールアドレス</label>
        <input class="register-form__input" type="text" name="name" id="name" placeholder="例：山田 太郎" value="{{ old('name') }}">
        <p class="register-form__error-message">
          @error('name')
          {{ $message }}
          @enderror
        </p>
      </div>
        <div class="register-form__group">
        <label class="register-form__label" for="password">パスワード</label>
        <input class="register-form__input" type="password" name="password" id="password" placeholder="例：coachtech1106">
        <p class="register-form__error-message">
          @error('password')
          {{ $message }}
          @enderror
        </p>
      </div>
            <button type="submit">ログイン</button>
        </div>
    </form>
</div>
@endsection