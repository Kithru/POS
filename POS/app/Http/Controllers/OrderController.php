<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $cart = session()->get('cart');

        if (!$cart || count($cart) == 0) {
            return back()->with('error', 'Cart is empty');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $order = Order::create([
            'customer_name'     => $request->customer_name,
            'customer_email'    => $request->customer_email,
            'customer_phone'    => $request->customer_phone,
            'customer_address'  => $request->customer_address,

            'receiver_name'     => $request->receiver_name,
            'receiver_email'    => $request->receiver_email,
            'receiver_phone'    => $request->receiver_phone,
            'receiver_address'  => $request->receiver_address,

            'notes'             => $request->notes,
            'status'            => '0',
            'total_amount'      => $total
        ]);

        foreach ($cart as $id => $item) {
            OrderItem::create([
                'order_id' => $order->order_id, // IMPORTANT (custom PK)
                'item_id'  => $id,
                'price'    => $item['price'],
                'quantity' => $item['quantity'],
                'subtotal' => $item['price'] * $item['quantity']
            ]);
        }

        session()->forget('cart');

        return redirect()->route('checkout')->with('success', 'Order placed successfully!');
    }

    public function index() {
        $cart = session('cart', []);
        return view('checkout', compact('cart'));
    }
}