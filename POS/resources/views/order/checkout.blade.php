@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{ asset('css/cart.css') }}">

<div class="checkout-container">

    <h2>🧾 Checkout</h2>

    <form action="{{ route('checkout.store') }}" method="POST">
        @csrf

        <div class="checkout-grid">

            <!-- Customer Details -->
            <div class="checkout-box">
                <h3>Customer Details</h3>

                <input type="text" name="name" placeholder="Full Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="text" name="phone" placeholder="Phone Number" required>
            </div>

            <!-- Delivery Details -->
            <div class="checkout-box">
                <h3>Delivery Details</h3>

                <input type="text" name="address" placeholder="Address" required>
                <input type="text" name="city" placeholder="City" required>
                <textarea name="notes" placeholder="Order Notes (Optional)"></textarea>
            </div>

        </div>

        <!-- Order Summary -->
        <div class="checkout-summary">
            <h3>Order Summary</h3>

            @php
                $total = 0;
            @endphp

            @foreach(session('cart') as $item)
                @php
                    $subtotal = $item['price'] * $item['quantity'];
                    $total += $subtotal;
                @endphp

                <p>
                    {{ $item['name'] }} (x{{ $item['quantity'] }}) 
                    - {{ number_format($subtotal,2) }}
                </p>
            @endforeach

            <h4>Total: {{ number_format($total,2) }}</h4>
        </div>

        <button type="submit" class="checkout-btn">
            Place Order
        </button>

    </form>

</div>

@endsection