@extends('layouts.auth')

@section('css')
<link rel="stylesheet" href="{{ asset('css/items/show.css') }}">
@endsection

@section('content')
<div class="item-data">
    <!-- 商品情報全体 -->
    <div class="item-header">
        <img src="{{ asset($item->image) }}" alt="{{ $item->name }}" class="item-image">
        <div class="item-details">
            <h1>{{ $item->name }}</h1>
            <p>ブランド名: {{ $item->brand_name }}</p>
            <p class="item-price">¥{{ number_format($item->price) }} (税込)</p>
            <p>
                <!-- お気に入りボタン -->
                <form action="{{ route('item.favorite', $item->id) }}" method="POST" style="display: inline;">
                    @csrf
                    <input type="hidden" name="_method" value="{{ $isFavorite ? 'DELETE' : 'POST' }}">
                    <button type="submit" class="star-btn {{ $isFavorite ? 'favorited' : '' }}">
                        <span>☆{{ $item->favorites()->count() }}</span>
                    </button>
                     <span class="comment-icon" >💬 {{ $item->comments()->count() }}</span>
                </form>
            </p>
        </div>
    </div>

    <!-- 商品説明 -->
    <div class="item-description">
        <h2>商品説明</h2>
        <p>カラー: グレー</p>
        <p>商品の状態: {{ $item->condition->condition }}</p>
        <p>{{ $item->description }}</p>
    </div>

    <!-- 商品情報 -->
    <div class="item-info">
        <h2>商品の情報</h2>
        <p>カテゴリー:
            @if($item->categories && $item->categories->isNotEmpty())
                @foreach ($item->categories as $category)
                    <span>{{ $category->name }}</span>@if (!$loop->last), @endif
                @endforeach
            @endif
        </p>
    </div>

    <!-- コメント一覧 -->
    <div class="item-comments">
        <h2>コメント ({{ $item->comments->count() }})</h2>
        @forelse ($comments as $comment)
            <div class="comment">
                <p><strong>{{ $comment->user->name }}:</strong> {{ $comment->comment }}</p>
            </div>
        @empty
            <p>コメントはまだありません。</p>
        @endforelse

        <!-- コメント投稿フォーム -->
        <form action="{{ route('item.comment', $item->id) }}" method="post">
            @csrf
            <textarea name="comment" rows="3" placeholder="商品へのコメントを入力してください..."></textarea>
            <button type="submit" class="btn">コメントを送信する</button>
        </form>
    </div>
</div>
@endsection
