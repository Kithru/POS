<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderCustomer;
use PDF;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function store(Request $request) {
        $cart = session()->get('cart');
        $codAmount = $request->input('cod_amount', 0);

        if (empty($cart) || count($cart) == 0) {
            return back()->with('error', 'Cart is empty');
        }

        // Calculate total
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Optional discount and tax
        $discount = $request->input('discount', 0);
        $tax = $request->input('tax', 0);
        $finalTotal = $total - $discount + $tax;

        // Generate order code
        $dateTimePart = now()->format('dmyH'); 
        $randomPart = rand(1000, 9999);
        $orderCode = $dateTimePart . $randomPart;

        // Create order
        $order = Order::create([
            'order_code'   => $orderCode,
            'total_amount' => $finalTotal,
            'discount'     => $discount,
            'tax'          => $tax,
            'cod_amount'   => $codAmount,
            'status'       => '0',
            'notes'        => $request->notes,
        ]);

        // Create order_customer
        OrderCustomer::create([
            'order_id'                => $order->order_id,
            'order_code'              => $orderCode,
            'customer_first_name'     => $request->customer_first_name,
            'customer_last_name'      => $request->customer_last_name,
            'customer_email'          => $request->customer_email,
            'customer_phone'          => $request->customer_phone,
            'postal_code'             => $request->postal_code,
            'perfecture'              => $request->perfecture,
            'city'                    => $request->city,
            'street_name'             => $request->street_name,
            'apartment_no'            => $request->apartment_no,
            'receiver_first_name'     => $request->receiver_first_name,
            'receiver_last_name'      => $request->receiver_last_name,
            'receiver_email'          => $request->receiver_email,
            'receiver_phone'          => $request->receiver_phone,
            'receiver_postal_code'    => $request->receiver_postal_code,
            'receiver_prefecture'     => $request->receiver_prefecture,
            'receiver_city'           => $request->receiver_city,
            'receiver_street_name'    => $request->receiver_street_name,
            'receiver_apartment_no'   => $request->receiver_apartment_no,
            'notes'                   => $request->notes,
        ]);

        // Save order items
        foreach ($cart as $id => $item) {
            OrderItem::create([
                'order_id' => $order->order_id,
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
        $prefectures = DB::table('prefectures')->get();
        return view('order.checkout', compact('cart', 'prefectures'));
    }

    public function receipt($order_id){
        try {
            $id = \Crypt::decryptString($order_id);
            $order = Order::with(['items.item', 'customer'])->findOrFail($id);
            return view('order.receipt_view', compact('order'));
        } catch (\Exception $e) {
            abort(404, 'Invalid order ID.');
        }
    }
    
    public function downloadPdf($order_id){
        try {
            $id = Crypt::decryptString($order_id);
            $order = Order::with(['items.item', 'customer'])->findOrFail($id);
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
            $order = Order::with(['items.item','customer'])->where('order_code', $orderCode)->first();
        }
        return view('order.track_order', compact('order', 'orderCode'));
    }

    public function searchOrder(Request $request) {
        $orderCode = $request->input('order_code');
        $itemCode = $request->input('item_code');

        $ordersQuery = Order::with(['items.item','customer']);
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
        $orderCode = $request->input('order_code', null);
        $order = null;

        if ($orderCode) {
            $order = Order::with('customer')->where('order_code', $orderCode)->first();
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
        $order->cancelled_by = auth()->id();
        $order->cancelled_reason = $request->cancel_reason;
        $order->save();

        return back()->with('success', 'Order cancelled successfully.');
    }

    public function manage(Request $request) {
        $query = Order::query();
        if ($request->filled('order_code')) {
            $query->where('order_code', 'LIKE', '%' . $request->order_code . '%');
        }
        if ($request->status !== null && $request->status !== '') {
            $query->where('status', $request->status);
        }
        if ($request->filled('date_from')) {
            $query->whereDate('added_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('added_date', '<=', $request->date_to);
        }

        $orders = $query->orderBy('added_date', 'desc')->paginate(10);
        $orders->appends($request->all());
        return view('order.order_manage', compact('orders'));
    }

    public function viewOrders(Request $request) {
        $query = Order::query();
        if ($request->filled('order_code')) {
            $query->where('order_code', 'LIKE', '%' . $request->order_code . '%');
        }
        if ($request->status !== null && $request->status !== '') {
            $query->where('status', $request->status);
        }
        if ($request->filled('date_from')) {
            $query->whereDate('added_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('added_date', '<=', $request->date_to);
        }

        $orders = $query->orderBy('added_date', 'desc')->paginate(10);
        $orders->appends($request->all());
        return view('order.view_orders', compact('orders'));
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

        return redirect()->back()->with('success', 'Order status updated successfully!');
    }

    public function getItems($orderId) {
        $order = Order::with('customer')->where('order_id', $orderId)->first();
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
                'order_code' => $order->order_code,
                'status' => $order->status,
                'created_at' => $order->added_date,

                'customer' => [
                    'name' => $order->customer 
                        ? $order->customer->customer_first_name . ' ' . $order->customer->customer_last_name 
                        : 'N/A',
                    'email' => $order->customer->customer_email ?? 'N/A',
                    'phone' => $order->customer->customer_phone ?? 'N/A',
                ],

                'receiver' => [
                    'name' => $order->customer 
                        ? $order->customer->receiver_first_name . ' ' . $order->customer->receiver_last_name 
                        : 'N/A',
                    'email' => $order->customer->receiver_email ?? 'N/A',
                    'phone' => $order->customer->receiver_phone ?? 'N/A',
                    'address' => $order->customer 
                        ? ($order->customer->receiver_street_name . ', ' .
                        $order->customer->receiver_city . ', ' .
                        $order->customer->receiver_prefecture . ' - ' .
                        $order->customer->receiver_postal_code)
                        : 'N/A',
                ],

                'status_times' => $status_times
            ],
            'items' => $items
        ]);
    }
}