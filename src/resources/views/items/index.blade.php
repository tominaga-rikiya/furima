@extends('layouts.auth')

@section('css')
<link rel="stylesheet" href="{{ asset('css/items/index.css') }}">
@endsection

@section('content')
<h1>商品一覧</h1>

<!-- ボタンで表示を切り替え -->
<div class="buttons">
    <a href="{{ route('items.index') }}" class="button {{ request('tab') == 'all' ? 'active' : '' }}">全商品</a>

    <!-- 未認証でもマイリストボタンは表示 -->
    <a href="{{ route('items.index', ['tab' => 'mylist']) }}" class="button {{ request('tab') == 'mylist' ? 'active' : '' }}">マイリスト</a>
</div>

<!-- 商品リストの表示エリア -->
<div class="product-list">
    @if (request('tab') == 'all' || is_null(request('tab')))
        @foreach ($items as $item)
            <div class="product-item">
                <a href="{{ route('items.show', ['item_id' => $item->id]) }}">
                    <img src="{{ asset($item->image) }}" alt="{{ $item->name }}" width="200px">
                    <h3>{{ $item->name }}</h3>
                </a>
                @if ($item->is_sold)
                    <span class="sold-label">Sold</span>
                @endif
            </div>
        @endforeach
    @elseif (request('tab') == 'mylist')
        @auth
            @if ($favorites->isEmpty())
                <p>いいねした商品がありません。</p>
            @else
                @foreach ($favorites as $favorite)
                    <div class="product-item">
                         <a href="{{ route('items.show', ['item_id' => $favorite->item->id]) }}">
                        <img src="{{ asset($favorite->item->image) }}" alt="{{ $favorite->item->name }}" width="200px">
                        <h3>{{ $favorite->item->name }}</h3>
                        @if ($favorite->item->is_sold)
                            <span class="sold-label">Sold</span>
                        @endif
                    </div>
                @endforeach
            @endif
        @else
            <p></p>
        @endauth
    @endif
</div>
@endsection
