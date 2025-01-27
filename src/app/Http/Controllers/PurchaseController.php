<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class PurchaseController extends Controller
{
    public function show(Request $request)

      $item = item::find($request->input('item_id'));
        
        if (!$item) {
            return redirect()->route('item.show', ['id' => $request->input('item_id')])->with('error', '商品が見つかりませんでした');
        }

        return view('checkout.index', compact('item'));
}
