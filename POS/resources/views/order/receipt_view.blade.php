@extends('layouts.blank')

@section('content')

@php
use Illuminate\Support\Facades\Crypt;

$encryptedOrderId = Crypt::encryptString($order->order_id);

/* Correct totals */
$subtotal = $order->total_amount - $order->tax - $order->cod_amount;
$grandTotal = $subtotal + $order->tax + $order->cod_amount;

function formatPrice($price) {
    return number_format($price, $price == floor($price) ? 0 : 2);
}


@endphp

<link rel="stylesheet" href="{{ asset('css/receipt.css') }}">

<div class="receipt-container" id="receipt-content">

    @if(session('success'))
        <script>alert("{{ session('success') }}");</script>
    @endif

    <div class="receipt-header">
        <img src="{{ asset('images/logo.png') }}" class="logo" style="max-height:80px; display:block; margin:auto;">
        <h1>Order Receipt</h1>
        <p><strong>Order ID:</strong> {{ $order->order_code }}</p>
        <p><strong>Date:</strong> {{ $order->added_date->format('d M Y, H:i') }}</p>
    </div>

    <!-- Restaurant -->
    <div class="section card">
        <h2>Restaurant Info</h2>
        <p><strong>Name:</strong> Rajarata Sakura Restaurant</p>
        <p><strong>Phone:</strong> +81 80-1756-2569 / 0296 48 6606</p>
        <p><strong>Address:</strong> 110-65, FUNYU, CHIKUSEI SHI, IBARAKI KEN, JAPAN</p>
    </div>

    <!-- Customer -->
    <div class="section card">
        <h2>Customer Details</h2>

        @if($order->customer)
            <p><strong>Name:</strong>
                {{ $order->customer->customer_first_name }}
                {{ $order->customer->customer_last_name }}
            </p>

            <p><strong>Email:</strong> {{ $order->customer->customer_email }}</p>
            <p><strong>Phone:</strong> {{ $order->customer->customer_phone }}</p>

            <p><strong>Address:</strong>
                {{ $order->customer->street_name }},
                {{ $order->customer->city }},
                {{ $order->customer->prefecture }},
                {{ $order->customer->postal_code }}
                @if($order->customer->apartment_no)
                    , {{ $order->customer->apartment_no }}
                @endif
            </p>
        @endif
    </div>

    <!-- Delivery -->
    <div class="section card">
        <h2>Delivery Details</h2>

        @if($order->customer)
            <p><strong>Name:</strong>
                {{ $order->customer->receiver_first_name }}
                {{ $order->customer->receiver_last_name }}
            </p>

            <p><strong>Email:</strong> {{ $order->customer->receiver_email }}</p>
            <p><strong>Phone:</strong> {{ $order->customer->receiver_phone }}</p>

            <p><strong>Address:</strong>
                {{ $order->customer->receiver_street_name }},
                {{ $order->customer->receiver_city }},
                {{ $order->customer->receiver_prefecture }},
                {{ $order->customer->receiver_postal_code }}
                @if($order->customer->receiver_apartment_no)
                    , {{ $order->customer->receiver_apartment_no }}
                @endif
            </p>
        @endif
    </div>

    <!-- Payment -->
    <div class="section card">
        <h2>Payment Details</h2>
        <p><strong>Payment Method:</strong> Cash On Delivery</p>
        <p><strong>Subtotal:</strong> ¥ {{ formatPrice($subtotal) }}</p>
        <p><strong>Tax (8%):</strong> ¥ {{ formatPrice($order->tax) }}</p>
        <p><strong>COD Amount:</strong> ¥ {{ formatPrice($order->cod_amount) }}</p>
    </div>

    <!-- Items -->
    <div class="section card">
        <h2>Order Items</h2>

        <table class="items-table">
            <thead>
                <tr>
                    <th>Item Name</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                </tr>
            </thead>

            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->item->item_name ?? 'N/A' }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>¥ {{ formatPrice($item->price) }}</td>
                    <td>¥ {{ formatPrice($item->subtotal) }}</td>
                </tr>
                @endforeach

                <tr>
                    <td colspan="3" style="text-align:right;">Subtotal</td>
                    <td>¥ {{ formatPrice($subtotal) }}</td>
                </tr>

                <tr>
                    <td colspan="3" style="text-align:right;">Tax</td>
                    <td>¥ {{ formatPrice($order->tax) }}</td>
                </tr>

                <tr>
                    <td colspan="3" style="text-align:right;">COD Amount</td>
                    <td>¥ {{ formatPrice($order->cod_amount) }}</td>
                </tr>

                <tr class="total-row">
                    <td colspan="3" style="text-align:right;"><strong>Total Amount</strong></td>
                    <td><strong>¥ {{ formatPrice($grandTotal) }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>

    @if($order->notes)
    <div class="section card">
        <h2>Notes</h2>
        <p>{{ $order->notes }}</p>
    </div>
    @endif

    <div class="print-btn-container multi-btn">
        <button onclick="downloadReceipt()" class="print-btn">🖨 Download Receipt</button>
        <a href="{{ route('home') }}" class="home-btn">🏠 Home</a>
        <a href="{{ route('order.track', ['order_code' => $order->order_code]) }}" class="tracking-btn">📦 Track Order</a>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    window.location.href = "{{ route('order.pdf', $encryptedOrderId) }}";
});

function downloadReceipt() {
    window.location.href = "{{ route('order.pdf', $encryptedOrderId) }}";
}
</script>

@endsection