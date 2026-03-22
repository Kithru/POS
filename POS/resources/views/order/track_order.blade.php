@extends('layouts.blank')

@section('content')

@php
use Illuminate\Support\Facades\Crypt;
@endphp

<link rel="stylesheet" href="{{ asset('css/order_track.css') }}">

<div class="receipt-container">

    <!-- Title -->
    <h1 class="track-title" style="text-align:center;">📦 Track Your Order</h1>
    <h3 class="restaurant-name" style="text-align:center; color:#8e44ad;">Rajarata Sakura Restaurant</h3>

    <!-- Search Form -->
    <form action="{{ route('order.track') }}" method="GET" class="search-form" style="justify-content:center; display:flex; margin-bottom:30px;">
        <input type="text" name="order_code" placeholder="Enter Order ID" value="{{ $orderCode ?? '' }}" style="padding:12px 15px; border-radius:8px; border:2px solid #8e44ad;">
        <button type="submit" class="search-btn" style="padding:12px 20px; background-color:#8e44ad; color:#fff; border-radius:8px; margin-left:10px;">Search</button>
    </form>

    <div class="print-btn-container multi-btn" style="justify-content:center; display:flex; gap:20px; margin-bottom:50px;">
        <a href="{{ url('/') }}" class="home-btn" style="background-color:#6c5ce7; padding:10px 20px; border-radius:8px; color:#fff;">Back to Home</a>
    </div>

    @if($order)
        <!-- Order Status -->
        <div class="section card">
            <h2 style="text-align:center;">Order Status</h2>

            <div class="order-status-tracker">
                @php
                    $statuses = [
                        0 => 'Pending',
                        1 => 'Confirmed',
                        2 => 'Preparing',
                        3 => 'Handed Over'
                    ];
                @endphp

                @foreach($statuses as $key => $label)
                    <div class="status-step {{ $order->status > $key ? 'completed' : ($order->status == $key ? 'current' : '') }}">
                        <div class="circle">
                            @if($order->status > $key)
                                &#10003;
                            @else
                                {{ $key + 1 }}
                            @endif
                        </div>
                        <div class="label">{{ $label }}</div>
                        @if(!$loop->last)
                            <div class="line {{ $order->status > $key ? 'active-line' : '' }}"></div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        @php
            $encryptedOrderId = Crypt::encryptString($order->order_id);
        @endphp

        <!-- Order Details -->
        <div class="section card">
            <h2 style="text-align:center;">Order Details</h2>
            <p><strong>Order ID:</strong> {{ $order->order_code }}</p>
            <p><strong>Date:</strong> {{ $order->added_date->format('d M Y, H:i') }}</p>
        </div>

        <!-- Customer Details -->
        <div class="section card">
            <h2 style="text-align:center;">Customer Details</h2>
            <p><strong>Name:</strong> {{ $order->customer_name }}</p>
            <p><strong>Email:</strong> {{ $order->customer_email }}</p>
            <p><strong>Phone:</strong> {{ $order->customer_phone }}</p>
            <p><strong>Address:</strong> {{ $order->customer_address }}</p>
        </div>

        <!-- Delivery Details -->
        <div class="section card">
            <h2 style="text-align:center;">Delivery Details</h2>
            <p><strong>Name:</strong> {{ $order->receiver_name }}</p>
            <p><strong>Email:</strong> {{ $order->receiver_email }}</p>
            <p><strong>Phone:</strong> {{ $order->receiver_phone }}</p>
            <p><strong>Address:</strong> {{ $order->receiver_address }}</p>
        </div>

        <!-- Payment Details -->
        <div class="section card">
            <h2 style="text-align:center;">Payment Details</h2>
            <p><strong>Payment Method:</strong> Cash On Delivery</p>
        </div>

        <!-- Items Table -->
        <div class="section card">
            <h2 style="text-align:center;">Order Items</h2>
            <table class="items-table">
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Item Code</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item->item->item_name ?? 'N/A' }}</td>
                            <td>{{ $item->item->item_code ?? 'N/A' }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($item->price, 2) }}</td>
                            <td>{{ number_format($item->quantity * $item->price, 2) }}</td>
                        </tr>
                    @endforeach
                    <tr class="total-row">
                        <td colspan="4" style="text-align:right;"><strong>Total Amount</strong></td>
                        <td><strong>{{ number_format($order->total_amount, 2) }}</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Notes -->
        @if($order->notes)
            <div class="section card">
                <h2 style="text-align:center;">Notes</h2>
                <p>{{ $order->notes }}</p>
            </div>
        @endif

        <!-- Buttons -->
        <div class="print-btn-container multi-btn" style="justify-content:center; display:flex; gap:20px; margin-bottom:50px;">
            <a href="{{ url('/') }}" class="home-btn" style="background-color:#6c5ce7; padding:10px 20px; border-radius:8px; color:#fff;">Back to Home</a>
            <a href="{{ route('order.receipt', ['order_id' => $encryptedOrderId]) }}" class="receipt-btn" style="background-color:#00b894; padding:10px 20px; border-radius:8px; color:#fff;">View Receipt</a>
        </div>

    @elseif($orderCode)
        <p style="text-align:center; color:red; font-weight:600;">No order found with Order Code "{{ $orderCode }}"</p>
    @endif

</div>

@endsection