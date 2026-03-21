<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;

class OrderController extends Controller
{
    public function store(Request $request) {
        $cart = session()->get('cart');

        if (!$cart || count($cart) == 0) {
            return back()->with('error', 'Cart is empty');
        }

        // Calculate total
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Generate order code
        $orderCode = now()->format('YmdHi') . rand(100, 999); 
        // now()->format('YmdHi') => 202603211300, rand(100,999) => 738, full code: 202603211300738

        $order = Order::create([
            'order_code'        => $orderCode,
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
                'order_id' => $order->order_id, // custom PK
                'item_id'  => $id,
                'price'    => $item['price'],
                'quantity' => $item['quantity'],
                'subtotal' => $item['price'] * $item['quantity']
            ]);
        }

        session()->forget('cart');

        return redirect()->route('checkout')->with('success', "Order placed successfully! Your order code is $orderCode");
    }

    public function index() {
        $cart = session('cart', []);
        return view('order.checkout', compact('cart'));
    }
}