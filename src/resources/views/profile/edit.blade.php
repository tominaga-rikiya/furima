@extends('layouts.auth')

@section('content')
<div class="container">
    <h2>プロフィール設定</h2>
    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="address">住所</label>
            <input type="text" name="address" class="form-control" value="{{ old('address') }}">
        </div>
        <div class="form-group">
            <label for="phone">電話番号</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
        </div>
        <button type="submit" class="btn btn-primary">更新する</button>
    </form>
</div>
@endsection
