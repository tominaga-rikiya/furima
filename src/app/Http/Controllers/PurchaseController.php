<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Requests\AddressRequest;

class PurchaseController extends Controller
{
     public function create($item_id)
    {
        $item = Item::findOrFail($item_id);
        if ($item->is_sold) {
            return redirect()->route('item.index')->with('error', 'この商品は既に売却済みです。');
        }
        
        $profile = auth()->user()->profile;
        $subtotal = $item->price;
        $paymentMethod = session('payment_method', 'credit_card');
        
        return view('purchase.create', compact('item', 'profile', 'subtotal', 'paymentMethod'));
    }

public function store(Request $request, Item $item)
{
    $request->validate([
        'address' => 'required',
        'payment_method' => 'required',
    ]);

  
    if ($item->is_sold) {
        return redirect()->route('item.index');
    }

    $item->is_sold = true;
    $item->save();

    if ($request->payment_method === 'credit_card') {

        return $this->processCreditCardPayment($request);
    } elseif ($request->payment_method === 'convenience_store') {
   
        return $this->processConvenienceStorePayment($request);
    }

    return redirect()->route('item.index')->with('success', '商品を購入しました！');
}
    
    public function showAddressForm(Item $item)
    {
        $profile = auth()->user()->profile;

        return view('purchase.address',compact('profile','item'));
    }

    public function updateAddress(AddressRequest $request,Item $item)
    {
        $profile =auth()->user()->profile;
        $profile->update([
            'postal_code'=>$request->postal_code,
            'address'=>$request->address,
            'building_name'=>$request->building_name,
        ]);
        
        return redirect()->route('purchase.create', ['item' => $item->id]);
    }
}

