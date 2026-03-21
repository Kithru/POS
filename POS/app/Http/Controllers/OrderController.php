<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use PDF;
use Illuminate\Support\Facades\Crypt;

class OrderController extends Controller
{
    public function store(Request $request) {
        $cart = session()->get('cart');

        if (empty($cart)) {
            return back()->with('error', 'Cart is empty');
        }

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

        $encryptedId = Crypt::encryptString($order->order_id);
        return redirect()->route('order.receipt', ['order_id' => $encryptedId])
                        ->with('success', "Order placed successfully! Your order code is $orderCode");
    }

    public function index() {
        $cart = session('cart', []);
        return view('order.checkout', compact('cart'));
    }

    public function receipt($order_id){
        try {
            $id = Crypt::decryptString($order_id); 
            $order = Order::with('items.item')->findOrFail($id);

            return view('order.receipt_view', compact('order'));
        } catch (\Exception $e) {
            abort(404, 'Invalid order ID.');
        }
    }

    public function downloadPdf($order_id){
        try {
            $id = Crypt::decryptString($order_id);
            $order = Order::with('items.item')->findOrFail($id);
            $pdf = PDF::loadView('order.receipt_pdf', compact('order'))
                    ->setPaper('A4', 'portrait');

            return $pdf->download("Order_{$order->order_code}.pdf");
        } catch (\Exception $e) {
            abort(404, 'Invalid order ID.');
        }
    }

    public function trackOrderPage(Request $request){
        $orderCode = $request->input('order_code');
        $order = null;
        if ($orderCode) {
            $order = Order::with('items.item')->where('order_code', $orderCode)->first();
        }
        return view('order.track_order', compact('order', 'orderCode'));
    }

    // Search within order by item_code
    public function searchOrder(Request $request) {
        $orderCode = $request->input('order_code');
        $itemCode = $request->input('item_code');

        $ordersQuery = Order::with(['items.item']);
        if ($orderCode) {
            $ordersQuery->where('order_code', $orderCode);
        }

        $orders = $ordersQuery->get();
        if ($itemCode) {
            foreach ($orders as $order) {
                $order->items = $order->items->filter(function($orderItem) use ($itemCode) {
                    return $orderItem->item && $orderItem->item->item_code === $itemCode;
                });
            }
        }

        return view('order.track_order', [
            'orders' => $orders,
            'orderCode' => $orderCode,
            'itemCode' => $itemCode,
        ]);
    }

    public function track(Request $request){
        $orderCode = $request->input('order_code', null); // optional
        $order = null;

        if ($orderCode) {
            $order = Order::where('order_code', $orderCode)->first();
        }
        return view('order.track', compact('order', 'orderCode'));
    }

    public function itemsByCategory($id){
        $category = Category::findOrFail($id);
        $items = $category->items()->where('status', 1)->get();
        return view('items.by_category', compact('category', 'items'));
    }

}