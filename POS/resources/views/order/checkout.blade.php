@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{ asset('css/order.css') }}">

<div class="checkout-container">

    <h2>🧾 Checkout</h2>

    <!-- Continue Shopping (TOP for better UX) -->
    <div class="continue-top">
        <a href="{{ url('/') }}" class="add-more-btn">
            ← Continue Shopping
        </a>
    </div>

    <form action="{{ route('checkout.store') }}" method="POST">
        @csrf

        <div class="checkout-grid">

            <!-- Customer Details -->
            <div class="checkout-box">
                <h3>Customer Details</h3>

                <input type="text" name="customer_name" placeholder="Full Name" required>
                <input type="email" name="customer_email" placeholder="Email" required>
                <input type="text" name="customer_phone" placeholder="Phone" required>
                <input type="text" name="customer_address" placeholder="Address" required>
            </div>

            <!-- Delivery Details -->
            <div class="checkout-box">
                <h3>Delivery Details</h3>

                <input type="text" name="receiver_name" placeholder="Receiver Name" required>
                <input type="email" name="receiver_email" placeholder="Receiver Email" required>
                <input type="text" name="receiver_phone" placeholder="Receiver Phone" required>
                <input type="text" name="receiver_address" placeholder="Receiver Address" required>

                <textarea name="notes" placeholder="Notes (Optional)"></textarea>
            </div>

        </div>

        <!-- Order Summary -->
        <div class="checkout-summary">
            <h3>Order Summary</h3>

            @php $total = 0; @endphp

            @foreach(session('cart') as $item)
                @php
                    $subtotal = $item['price'] * $item['quantity'];
                    $total += $subtotal;
                @endphp

                <p>
                    <span>{{ $item['name'] }} (x{{ $item['quantity'] }})</span>
                    <span>{{ number_format($subtotal, 2) }}</span>
                </p>
            @endforeach

            <h4>Total: {{ number_format($total, 2) }}</h4>
        </div>

        <!-- ACTION BUTTONS -->
        <div class="checkout-actions">

            <button type="submit" class="checkout-btn">
                ✅ Place Order
            </button>

            <a href="{{ url('/') }}" class="add-more-btn">
                🛒 Continue Shopping
            </a>

        </div>

    </form>

</div>

@endsection