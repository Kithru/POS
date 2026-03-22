<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use PDF;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;

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
        $dateTimePart = now()->format('dmyH'); // d=day, m=month, y=last 2 digits of year, H=hour (24h)
        // Generate 4 random digits
        $randomPart = rand(1000, 9999);
        $orderCode = $dateTimePart . $randomPart;

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

    public function cancel(Request $request, $order_code){
        $request->validate([
            'cancel_reason' => 'required|string|max:500'
        ]);

        $order = Order::where('order_code', $order_code)->firstOrFail();
        if ($order->status != 0) {
            return back()->with('error', 'Order cannot be cancelled.');
        }
        $order->status = 4;
        $order->cancelled_date = now();
        $order->cancelled_by = auth()->id(); // or null if guest
        $order->cancelled_reason = $request->cancel_reason;
        $order->save();

        return back()->with('success', 'Order cancelled successfully.');
    }

    public function manage(){
        $orders = Order::orderBy('order_id', 'desc')->paginate(10);
        return view('order.order_manage', compact('orders'));
    }

    public function updateStatus(Request $request, $id){
        $order = Order::findOrFail($id);
        $status = $request->status;
        $order->status = $status;
        if ($status == 1) {
            $order->confirmed_date = Carbon::now();
        } elseif ($status == 2) {
            $order->prepared_date = Carbon::now();
        } elseif ($status == 3) {
            $order->hand_over_date = Carbon::now();
        } elseif ($status == 4) {
            $order->cancelled_date = Carbon::now();
            $order->cancelled_reason = $request->cancel_reason;
        }

        $order->save();
        if ($status == 4) {
            return redirect()->back()->with('success', 'Order has been cancelled!');
        }

        return redirect()->back()->with('success', 'Order status updated successfully!');
    }

    public function getItems($orderId) {
        $order = \DB::table('orders')->where('order_id', $orderId)->first();
        $items = \DB::table('order_items')
            ->join('items', 'order_items.item_id', '=', 'items.item_id')
            ->where('order_items.order_id', $orderId)
            ->select('items.item_name', 'order_items.quantity', 'order_items.price')
            ->get();

        $status_times = [
            0 => $order->added_date,
            1 => $order->confirmed_date,
            2 => $order->prepared_date,
            3 => $order->hand_over_date,
            4 => $order->cancelled_date
        ];

        return response()->json([
            'order' => [
                'order_code'   => $order->order_code,
                'status'       => $order->status,
                'created_at'   => $order->added_date,
                'customer_name'=> $order->customer_name, // <-- added customer name
                'status_times' => $status_times
            ],
            'items' => $items
        ]);
    }


}