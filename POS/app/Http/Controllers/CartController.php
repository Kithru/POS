<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller{

    public function add(Request $request){

        $cart = session()->get('cart', []);
        $id = $request->id;
        if(isset($cart[$id])){
            $cart[$id]['quantity'] += $request->quantity;
        }else{
            $cart[$id] = [
                "name" => $request->name,
                "price" => $request->price,
                "image" => $request->image,
                "quantity" => $request->quantity
            ];

        }
        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'count' => count($cart)
        ]);
    }

    public function index(){
        $cart = session()->get('cart', []);
        return view('cart', compact('cart'));
    }

}
