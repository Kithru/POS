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

                <input type="text" name="customer_name" id="customer_name" placeholder="Full Name" required>
                <input type="email" name="customer_email" id="customer_email" placeholder="Email" required>
                <input type="text" name="customer_phone" id="customer_phone" placeholder="Phone" required>
                <input type="text" name="customer_address" id="customer_address" placeholder="Address" required>
            </div>

            <!-- Delivery Details -->
            <div class="checkout-box">
                <h3>Delivery Details</h3>

                <!-- Modern toggle switch for "Same as Customer" -->
                <label class="switch">
                    <input type="checkbox" id="sameAsCustomer">
                    <span class="slider"></span>
                    <span class="label-text">Same as Customer Details</span>
                </label>

                <input type="text" name="receiver_name" id="receiver_name" placeholder="Receiver Name" required>
                <input type="email" name="receiver_email" id="receiver_email" placeholder="Receiver Email" required>
                <input type="text" name="receiver_phone" id="receiver_phone" placeholder="Receiver Phone" required>
                <input type="text" name="receiver_address" id="receiver_address" placeholder="Receiver Address" required>

                <textarea name="notes" placeholder="Notes (Optional)"></textarea>
            </div>

        </div>

        <!-- Order Summary -->
        <div class="checkout-summary">
            <h3>Order Summary</h3>

            @php 
                $total = 0; 
                $cartItems = $cart ?? []; // Use cart from controller or empty array
            @endphp

            @if(count($cartItems) > 0)
                @foreach($cartItems as $item)
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
            @else
                <p>Your cart is empty.</p>
                <h4>Total: 0.00</h4>
            @endif
        </div>

        <!-- ACTION BUTTONS -->
        <div class="checkout-actions">
            <button type="submit" class="checkout-btn" @if(count($cartItems) == 0) disabled @endif>
                ✅ Place Order
            </button>

            <a href="{{ url('/') }}" class="add-more-btn">
                🛒 Continue Shopping
            </a>
        </div>

    </form>

</div>

<!-- JavaScript for auto-fill delivery fields -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const checkbox = document.getElementById('sameAsCustomer');

    checkbox.addEventListener('change', function () {
        if (this.checked) {
            document.getElementById('receiver_name').value = document.getElementById('customer_name').value;
            document.getElementById('receiver_email').value = document.getElementById('customer_email').value;
            document.getElementById('receiver_phone').value = document.getElementById('customer_phone').value;
            document.getElementById('receiver_address').value = document.getElementById('customer_address').value;
        } else {
            document.getElementById('receiver_name').value = '';
            document.getElementById('receiver_email').value = '';
            document.getElementById('receiver_phone').value = '';
            document.getElementById('receiver_address').value = '';
        }
    });
});
</script>

@endsection