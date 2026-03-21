@extends('layouts.blank')

@section('content')

@php
use Illuminate\Support\Facades\Crypt;
$encryptedOrderId = Crypt::encryptString($order->order_id);
@endphp

<link rel="stylesheet" href="{{ asset('css/receipt.css') }}">

<div class="receipt-container" id="receipt-content">

    <!-- Success Alert -->
    @if(session('success'))
        <script>alert("{{ session('success') }}");</script>
    @endif

    <div class="receipt-header">
        <h1>🍽 Order Receipt</h1>
        <p><strong>Order ID:</strong> {{ $order->order_code }}</p>
        <p><strong>Date:</strong> {{ $order->added_date->format('d M Y, H:i') }}</p>
    </div>

    <!-- Restaurant Details -->
    <div class="section card">
        <h2>Restaurant Info</h2>
        <p><strong>Name:</strong> Rajarata Sakura Restaurant</p>
        <p><strong>Phone:</strong> +94 123 456 789</p>
        <p><strong>Address:</strong> 123 Main Street, Colombo</p>
    </div>

    <!-- Customer Details -->
    <div class="section card">
        <h2>Customer Details</h2>
        <p><strong>Name:</strong> {{ $order->customer_name }}</p>
        <p><strong>Email:</strong> {{ $order->customer_email }}</p>
        <p><strong>Phone:</strong> {{ $order->customer_phone }}</p>
        <p><strong>Address:</strong> {{ $order->customer_address }}</p>
    </div>

    <!-- Delivery Details -->
    <div class="section card">
        <h2>Delivery Details</h2>
        <p><strong>Name:</strong> {{ $order->receiver_name }}</p>
        <p><strong>Email:</strong> {{ $order->receiver_email }}</p>
        <p><strong>Phone:</strong> {{ $order->receiver_phone }}</p>
        <p><strong>Address:</strong> {{ $order->receiver_address }}</p>
    </div>

    <!-- Payment Details -->
    <div class="section card">
        <h2>Payment Details</h2>
        <p><strong>Payment method:</strong> Cash On Delivery </p>
    </div>

    <!-- Items Table -->
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
                        <td>{{ number_format($item->price, 2) }}</td>
                        <td>{{ number_format($item->subtotal, 2) }}</td>
                    </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="3" style="text-align:right;"><strong>Total Amount</strong></td>
                    <td><strong>{{ number_format($order->total_amount, 2) }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Notes -->
    @if($order->notes)
    <div class="section card">
        <h2>Notes</h2>
        <p>{{ $order->notes }}</p>
    </div>
    @endif

    <!-- Print Button -->
    <div class="print-btn-container multi-btn">
        <button onclick="printAndDownload()" class="print-btn"> 🖨 Download Receipt </button>
        <a href="{{ url('/') }}" class="home-btn"> 🏠 Home </a>
        <a href="{{ route('order.track', ['order_code' => $order->order_code]) }}" class="tracking-btn">📦 Track Order</a>
    </div>

</div>

<!-- Auto PDF download on page load -->
<script>

document.addEventListener('DOMContentLoaded', function () {
    window.location.href = "{{ route('order.pdf', Crypt::encryptString($order->order_id))}}";
});

function printAndDownload() {
    setTimeout(function() {
        window.location.href = "{{ route('order.pdf', Crypt::encryptString($order->order_id))}}";
    }, 500);
    
}
</script>

@endsection