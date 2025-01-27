<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;


class ItemController extends Controller
{
    public function index(Request $request)
    {
        // 検索クエリの取得
        $search = $request->input('search');

        // 全商品を取得（検索条件がある場合はフィルタリング）
        $items = Item::when($search, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%');
        })->when(auth()->check(), function ($query) {
            // ログイン中の場合、自分が出品した商品を除外
            return $query->where('user_id', '!=', auth()->id());
        })->get();
       
        // お気に入り商品リスト（ログインユーザーのみ取得）
        $favorites = auth()->check() ? auth()->user()->favorites : collect();

        // ビューに渡す
        return view('items.index', compact('items', 'favorites'));
    }

    public function store(Request $request)
    {
        // 商品画像の保存
        $path = $request->file('image')->store('images', 'public');

        // 商品の保存
        Item::create([
            'name' => $request->name,
            'image_path' => $path,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('item.index');
    }

    public function purchaseItem($id)
    {
        // 購入処理
        $item = Item::findOrFail($id);
        $item->is_sold = true;
        $item->save();

        return redirect()->route('item.index')->with('success', '商品を購入しました！');
    }

    public function show($id)
    {
        // 必要なリレーションを一括でロード
        $item = Item::with(['categories', 'favorites', 'comments.user'])->findOrFail($id);

        $isFavorite = auth()->check() && $item->favorites()->where('user_id', auth()->id())->exists();
        $comments = $item->comments()->with('user')->latest()->get();

        return view('items.show', compact('item', 'isFavorite', 'comments'));
    }
    
    
    public function favorite($item_id)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'ログインが必要です。');
        }

        $item = Item::findOrFail($item_id);

        // すでにお気に入りがある場合は、再度お気に入りを追加しない
        if (!auth()->user()->favorites()->where('item_id', $item->id)->exists()) {
            $item->favorites()->create(['user_id' => auth()->id()]);
        }
       
        // マイリストタブを表示するためにリダイレクト
        return redirect()->route('items.index', ['tab' => 'mylist'])->with('success', 'いいねしました');
    }

    public function toggleFavorite($itemId)
{
    $item = Item::findOrFail($itemId);
    $user = auth()->user();

    // お気に入りの状態をトグル
    if ($user->favorites()->where('item_id', $item->id)->exists()) {
        // すでにお気に入りの場合、削除
        $user->favorites()->where('item_id', $item->id)->delete();
    } else {
        // お気に入りに追加
        $user->favorites()->create(['item_id' => $item->id]);
    }

    return redirect()->route('item.show', $item->id);
}


    public function unfavorite($item_id)
    {
        $item = Item::findOrFail($item_id);
        $item->favorites()->where('user_id', auth()->id())->delete();

        return back()->with('success', 'いいねを解除しました');
    }

    public function comment(Request $request, $item_id)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'ログインが必要です。');
        }


        $request->validate([
            'comment' => 'required|string|max:255',
        ]);

        $comment = new Comment();
        $comment->item_id = $item_id;
        $comment->user_id = auth()->id();
        $comment->comment = $request->comment;
        $comment->save();

        return redirect()->route('items.show', $item_id);
    }

   





}

