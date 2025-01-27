@extends('layout.auth')

@foreach ($items as $item)
    <div class="item">
        <img src="{{ $item->image->url }}" alt="{{ $item->name }}" class="item-image">
        <h3>{{ $item->name }}</h3>
         <!-- 商品が購入されたかどうかをPurchaseテーブルで確認 -->
        @if ($item->purchases()->where('user_id', auth()->id())->where('status', 'completed')->exists())
            <span class="sold">Sold</span>
        @endif
    </div>
@endforeach

@endsection
