<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    // Add item to cart
    public function add(Request $request){
        $data = $request->validate([
            'id' => 'required|integer|exists:items,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'image' => 'nullable|string|max:255'
        ]);

        $cart = session()->get('cart', []);
        $id = $data['id'];

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $data['quantity'];
        } else {
            $cart[$id] = [
                'name' => $data['name'],
                'price' => $data['price'],
                'quantity' => $data['quantity'],
                'image' => $data['image'] ?? null
            ];
        }

        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'count' => count($cart)
        ]);
    }

    // Display cart page
    public function index(){
        $cart = session()->get('cart', []);
        return view('cart', compact('cart'));
    }
}

