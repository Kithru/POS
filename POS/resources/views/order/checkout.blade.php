@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{ asset('css/order.css') }}">

<style>
    .required {
        color: red;
        margin-left: 3px;
    }
</style>

<div class="checkout-container">

    <h2>🧾 Checkout</h2>

    <div class="continue-top">
        <a href="{{ route('home') }}" class="add-more-btn">
            ← Continue Shopping
        </a>
    </div>

    <form action="{{ route('checkout.store') }}" method="POST">
        @csrf

        <div class="checkout-grid">

            <!-- Customer Details -->
            <div class="checkout-box">
                <h3>Customer Details</h3>

                <label>First Name <span class="required">*</span></label>
                <input type="text" name="customer_first_name" id="customer_first_name" required>

                <label>Last Name <span class="required">*</span></label>
                <input type="text" name="customer_last_name" id="customer_last_name" required>

                <label>Country / Region</label>
                <p><strong>Japan</strong></p>
                <input type="hidden" name="country" value="Japan">

                <label>Postal Code <span class="required">*</span></label>
                <input type="text" name="postal_code" id="postal_code" required>

                <label>Prefecture <span class="required">*</span></label>
                <input type="text" name="perfecture" id="perfecture" required>

                <label>Town / City <span class="required">*</span></label>
                <input type="text" name="city" id="city" required>

                <label>Street Name <span class="required">*</span></label>
                <input type="text" name="street_name" id="street_name" required>

                <label>Apartment No</label>
                <input type="text" name="apartment_no" id="apartment_no">

                <label>Full Address <span class="required">*</span></label>
                <input type="text" name="customer_address" id="customer_address" required>

                <label>Email <span class="required">*</span></label>
                <input type="email" name="customer_email" id="customer_email" required>

                <label>Phone <span class="required">*</span></label>
                <input type="text" name="customer_phone" id="customer_phone" required>
            </div>

            <!-- Delivery Details -->
            <div class="checkout-box">
                <h3>Delivery Details</h3>

                <label class="switch">
                    <input type="checkbox" id="sameAsCustomer">
                    <span class="slider"></span>
                    <span class="label-text">Same as Customer Details</span>
                </label>

                <label>Receiver Name <span class="required">*</span></label>
                <input type="text" name="receiver_name" id="receiver_name" required>

                <label>Receiver Email <span class="required">*</span></label>
                <input type="email" name="receiver_email" id="receiver_email" required>

                <label>Receiver Phone <span class="required">*</span></label>
                <input type="text" name="receiver_phone" id="receiver_phone" required>

                <label>Delivery Address <span class="required">*</span></label>
                <input type="text" name="receiver_address" id="receiver_address" required>

                <label>Notes</label>
                <textarea name="notes" id="notes" placeholder="Optional instructions (e.g. leave at door)"></textarea>
            </div>

        </div>

        <!-- Order Summary -->
        <div class="checkout-summary">
            <h3>Order Summary</h3>

            @php 
                $total = 0; 
                $cartItems = $cart ?? [];
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

            <a href="{{ route('home') }}" class="add-more-btn">
                🛒 Continue Shopping
            </a>
        </div>

    </form>

</div>

<!-- JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const checkbox = document.getElementById('sameAsCustomer');

    checkbox.addEventListener('change', function () {
        if (this.checked) {
            const fullName = document.getElementById('customer_first_name').value + ' ' +
                             document.getElementById('customer_last_name').value;

            document.getElementById('receiver_name').value = fullName;
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