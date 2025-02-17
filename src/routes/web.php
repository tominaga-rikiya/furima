<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PurchaseController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Route::get('/', [ItemController::class, 'index'])->name('home');
Route::get('/items', [ItemController::class, 'index'])->name('item.index');
Route::get('/items/{tab}', [ItemController::class, 'index']);


Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile', [ProfileController::class, 'store'])->name('profile.store');
});



Route::get('login', fn() => view('auth.login'))->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('register', fn() => view('auth.register'))->name('register');
Route::post('register', [AuthController::class, 'register']);
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

Route::get('/item/{item_id}', [ItemController::class, 'show'])->name('item.show');
Route::prefix('item/{item_id}')->group(function () {
    Route::post('/favorite', [ItemController::class, 'favorite'])->name('item.favorite');
    Route::delete('/favorite', [ItemController::class, 'unfavorite'])->name('item.unfavorite');
    Route::post('/comment', [ItemController::class, 'comment'])->name('item.comment');
});


Route::prefix('item/{item_id}')->group(function () {
    Route::post('/favorite', [ItemController::class, 'favorite'])->name('item.favorite');
    Route::delete('/favorite', [ItemController::class, 'toggleFavorite']);
});

Route::middleware(['auth'])->group(function () {
    Route::get('purchase/{item_id}', [PurchaseController::class, 'create'])->name('purchase.create');
    Route::post('purchase/{item_id}', [PurchaseController::class, 'store'])->name('purchase.store');

    Route::get('purchase/address/{item_id}', [PurchaseController::class, 'showAddressForm'])->name('purchase.address');
    Route::put('purchase/address/{item_id}', [PurchaseController::class, 'updateAddress'])->name('purchase.update.address');
    }
);




