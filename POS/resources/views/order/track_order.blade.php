@extends('layouts.app')

@section('content')

@php
use Illuminate\Support\Facades\Crypt;
@endphp

<link rel="stylesheet" href="{{ asset('css/order.css') }}">

<div class="receipt-container">

    <h1>📦 Track Your Order</h1>

    <!-- Search Form -->
    <form action="{{ route('order.track') }}" method="GET" class="search-form">
        <input type="text" name="order_code" placeholder="Enter Order Code" value="{{ $orderCode ?? '' }}">
        <button type="submit" class="search-btn">Search</button>
    </form>

    <div class="section card">
        <h2>Order Status</h2>

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
                            &#10003; <!-- check mark for completed -->
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

    @if($order)
        @php
            $encryptedOrderId = Crypt::encryptString($order->order_id);
        @endphp

        <!-- Order Details -->
        <div class="section card">
            <h2>Order Details</h2>
            <p><strong>Order Code:</strong> {{ $order->order_code }}</p>
            <!-- <p><strong>Status:</strong> {{ $order->status }}</p> -->
            <p><strong>Date:</strong> {{ $order->added_date->format('d M Y, H:i') }}</p>
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

        <!-- Items Table -->
        <div class="section card">
            <h2>Order Items</h2>
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
            <h2>Notes</h2>
            <p>{{ $order->notes }}</p>
        </div>
        @endif

        <!-- Buttons -->
        <div class="print-btn-container multi-btn">
            <a href="{{ url('/') }}" class="home-btn">🏠 Home</a>
            <a href="{{ route('order.receipt', ['order_id' => $encryptedOrderId]) }}" class="receipt-btn">🧾 View Receipt</a>
        </div>

    @elseif($orderCode)
        <p>No order found with Order Code "{{ $orderCode }}"</p>
    @endif

</div>

@endsection