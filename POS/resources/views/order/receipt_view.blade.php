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
        <img src="{{ asset('images/logo.png') }}" alt="Company Logo" class="logo" style="max-height: 80px; display:block; margin-bottom:10px;">
        <h1>Order Receipt</h1>
        <p><strong>Order ID:</strong> {{ $order->order_code }}</p>
        <p><strong>Date:</strong> {{ $order->added_date->format('d M Y, H:i') }}</p>
    </div>

    <!-- Restaurant Details -->
    <div class="section card">
        <h2>Restaurant Info</h2>
        <p><strong>Name:</strong> Rajarata Sakura Restaurant</p>
        <p><strong>Phone:</strong> +81 80-1756-2569 / 0296 48 6606</p>
        <p><strong>Address:</strong> 110-65, FUNYU, CHIKUSEI SHI, IBARAKI KEN, JAPAN</p>
    </div>

    <!-- Customer Details -->
    <div class="section card">
        <h2>Customer Details</h2>
        @if($order->customer)
                <p><strong>Name:</strong> {{ $order->customer->customer_first_name ?? '' }} {{ $order->customer->customer_last_name ?? '' }}</p>
                <p><strong>Email:</strong> {{ $order->customer->customer_email ?? '' }}</p>
                <p><strong>Phone:</strong> {{ $order->customer->customer_phone ?? '' }}</p>
                <p><strong>Address:</strong> 
                    {{ $order->customer->postal_code ?? '' }},
                    {{ $order->customer->perfecture ?? '' }},
                    {{ $order->customer->city ?? '' }},
                    {{ $order->customer->street_name ?? '' }}
                    {{ $order->customer->apartment_no ?? '' }}
                </p>
        @else
            <p>No customer info available.</p>
        @endif
    </div>

    <!-- Delivery Details -->
    <div class="section card">
        <h2>Delivery Details</h2>
        @if($order->customer)
            <p><strong>Name:</strong> {{ $order->customer->receiver_first_name }} {{ $order->customer->receiver_last_name }}</p>
            <p><strong>Email:</strong> {{ $order->customer->receiver_email }}</p>
            <p><strong>Phone:</strong> {{ $order->customer->receiver_phone }}</p>
            <p><strong>Address:</strong>
                {{ $order->customer->receiver_street_name }},
                {{ $order->customer->receiver_city }},
                {{ $order->customer->receiver_prefecture }},
                {{ $order->customer->receiver_postal_code }}
                @if($order->customer->receiver_apartment_no), Apt: {{ $order->customer->receiver_apartment_no }}@endif
            </p>
        @else
            <p>No delivery info available.</p>
        @endif
    </div>

    <!-- Payment Details -->
    <div class="section card">
        <h2>Payment Details</h2>
        <p><strong>Payment method:</strong> Cash On Delivery</p>
        <p><strong>COD Amount:</strong> ¥ {{ number_format($order->cod_amount, 2) }}</p>
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
                        <td>¥ {{ number_format($item->price, 2) }}</td>
                        <td>¥ {{ number_format($item->subtotal, 2) }}</td>
                    </tr>
                @endforeach

                <!-- COD Row -->
                <tr>
                    <td colspan="3" style="text-align:right;"> COD Amount </td>
                    <td> ¥ {{ number_format($order->cod_amount, 2) }} </td>
                </tr>

                <!-- Final Total -->
                <tr class="total-row">
                    <td colspan="3" style="text-align:right;"><strong>Total Amount</strong></td>
                    <td><strong>¥ {{ number_format($order->total_amount + $order->cod_amount, 2) }}</strong></td>
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
        <a href="{{ route('home') }}" class="home-btn"> 🏠 Home </a>
        <a href="{{ route('order.track', ['order_code' => $order->order_code]) }}" class="tracking-btn">📦 Track Order</a>
    </div>

</div>

<!-- Auto PDF download on page load -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    window.location.href = "{{ route('order.pdf', $encryptedOrderId) }}";
});

function printAndDownload() {
    setTimeout(function() {
        window.location.href = "{{ route('order.pdf', $encryptedOrderId) }}";
    }, 500);
}
</script>

@endsection