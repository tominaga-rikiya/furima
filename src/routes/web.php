<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PurchaseController;
use App\Models\Purchase;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Route::get('/', [ItemController::class, 'index'])->name('home');
Route::get('/items', [ItemController::class, 'index'])->name('items.index');
Route::get('/{tab}', [ItemController::class, 'index']);

// 認証が必要なルートグループ
Route::middleware(['auth'])->group(function () {
    Route::get('/mypage', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/mypage/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// ログイン関連
Route::get('login', function () {
    return view('auth.login');
})->name('login');
Route::post('login', [AuthController::class, 'login']);

// 会員登録関連
Route::get('register', function () {
    return view('auth.register');
})->name('register');
Route::post('register', [AuthController::class, 'register']);

// ログアウト
Route::post('/logout', function () {
    Auth::logout(); // ログアウト処理
    return redirect('/'); // ホーム画面へリダイレクト
})->name('logout');

Route::post('/item/{item_id}/favorite', [ItemController::class, 'favorite'])->name('item.favorite');
Route::delete('/item/{item_id}/favorite', [ItemController::class, 'unfavorite'])->name('item.unfavorite');

Route::post('/item/{item_id}/comment', [ItemController::class, 'comment'])->name('item.comment');

Route::get('/item/{item_id}', [ItemController::class, 'show'])->name('items.show');


Route::get('/purchase/{item_id}', [PurchaseController::class, 'show'])->name('purchase.show');

Route::post('/item/{itemId}/favorite', [ItemController::class, 'toggleFavorite'])->name('item.togglefavorite');
Route::delete('/item/{itemId}/favorite', [ItemController::class, 'toggleFavorite']);