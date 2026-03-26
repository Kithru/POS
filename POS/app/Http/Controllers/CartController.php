<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class CartController extends Controller {

    public function add(Request $request){
        $request->validate([
            'item_id' => 'required|integer',
            'quantity' => 'required|integer|min:1'
        ]);

        $item = Item::select(
                    'items.*',
                    'currency.currency',
                    'currency.currency_icon'
                )
                ->join('currency', 'items.currency', '=', 'currency.id')
                ->where('items.item_id', $request->item_id)
                ->first();

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Item not found'
            ]);
        }

        $cart = session()->get('cart', []);
        $id = $item->item_id;

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $request->quantity;
        } else {
            $cart[$id] = [
                "name" => $item->item_name,
                "price" => $item->price,
                "currency" => $item->currency ?? '',
                "currency_icon" => $item->currency_icon ?? '',
                "description" => $item->description,
                "image" => $item->image
                    ? asset('images/uploads/' . $item->image)
                    : asset('images/no-image.jpg'),
                "quantity" => $request->quantity
            ];
        }
        session()->put('cart', $cart);
        $totalQty = array_sum(array_column($cart, 'quantity'));

        return response()->json([
            'success' => true,
            'count' => $totalQty
        ]);
    }

    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart', compact('cart'));
    }

    public function update(Request $request){
        $request->validate([
            'id' => 'required',
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = session()->get('cart', []);
        if (isset($cart[$request->id])) {
            $cart[$request->id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }

        return response()->json([
            'success' => true
        ]);
        
    }

  
    public function remove(Request $request){
        $cart = session()->get('cart', []);
        if (isset($cart[$request->id])) {
            unset($cart[$request->id]);
            session()->put('cart', $cart);
        }
        $totalQty = array_sum(array_column($cart, 'quantity'));

        return response()->json([
            'success' => true,
            'count' => $totalQty
        ]);
    }


    public function clear(){
        session()->forget('cart');
        return redirect()->back();
    }
}