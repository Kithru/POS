@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{ asset('css/order.css') }}">

<style>
    .required {
        color: red;
        margin-left: 3px;
    }
</style>

@php
$prefectures = [
    'Hokkaido','Aomori','Iwate','Miyagi','Akita','Yamagata','Fukushima',
    'Ibaraki','Tochigi','Gunma','Saitama','Chiba','Tokyo','Kanagawa',
    'Niigata','Toyama','Ishikawa','Fukui','Yamanashi','Nagano','Gifu',
    'Shizuoka','Aichi','Mie','Shiga','Kyoto','Osaka','Hyogo','Nara','Wakayama',
    'Tottori','Shimane','Okayama','Hiroshima','Yamaguchi','Tokushima','Kagawa',
    'Ehime','Kochi','Fukuoka','Saga','Nagasaki','Kumamoto','Oita','Miyazaki',
    'Kagoshima','Okinawa'
];
@endphp

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
                <input type="text" name="customer_first_name" id="customer_first_name" placeholder="John" required>

                <label>Last Name <span class="required">*</span></label>
                <input type="text" name="customer_last_name" id="customer_last_name" placeholder="Doe" required>

                <label>Country / Region</label>
                <p style="margin-bottom: 20px; margin-top: 10px;"><strong>Japan</strong></p>

                <label style="margin-top: 20px;">Postal Code <span class="required">*</span></label>
                <input type="text" name="postal_code" id="postal_code" placeholder="100-0001" required>

                <label>Prefecture <span class="required">*</span></label>
                <select name="perfecture" id="perfecture" required>
                    <option value="" disabled selected>Select Prefecture</option>
                    @foreach($prefectures as $pref)
                        <option value="{{ $pref }}">{{ $pref }}</option>
                    @endforeach
                </select>

                <label>Town / City <span class="required">*</span></label>
                <input type="text" name="city" id="city" placeholder="Chiyoda" required>

                <label>Street Name <span class="required">*</span></label>
                <input type="text" name="street_name" id="street_name" placeholder="1-1 Marunouchi" required>

                <label>Apartment No</label>
                <input type="text" name="apartment_no" id="apartment_no" placeholder="Apt 101">

                <label>Email <span class="required">*</span></label>
                <input type="email" name="customer_email" id="customer_email" placeholder="john.doe@example.com" required>

                <label>Phone <span class="required">*</span></label>
                <input type="text" name="customer_phone" id="customer_phone" placeholder="+81 90 1234 5678" required>
            </div>

            <!-- Delivery Details -->
            <div class="checkout-box">
                <h3>Delivery Details</h3>

                <label class="switch">
                    <input type="checkbox" id="sameAsCustomer">
                    <span class="slider"></span>
                    <span class="label-text">Same as Customer Details</span>
                </label>

                <label>First Name <span class="required">*</span></label>
                <input type="text" name="receiver_first_name" id="receiver_first_name" placeholder="John" required>

                <label>Last Name <span class="required">*</span></label>
                <input type="text" name="receiver_last_name" id="receiver_last_name" placeholder="Doe" required>

                <label>Country / Region</label>
                <p style="margin-bottom: 20px; margin-top: 10px;"><strong>Japan</strong></p>

                <label style="margin-top: 20px;">Postal Code <span class="required">*</span></label>
                <input type="text" name="receiver_postal_code" id="receiver_postal_code" placeholder="100-0001" required>

                <label>Prefecture <span class="required">*</span></label>
                <select name="receiver_prefecture" id="receiver_prefecture" required>
                    <option value="" disabled selected>Select Prefecture</option>
                    @foreach($prefectures as $pref)
                        <option value="{{ $pref }}">{{ $pref }}</option>
                    @endforeach
                </select>

                <label>Town / City <span class="required">*</span></label>
                <input type="text" name="receiver_city" id="receiver_city" placeholder="Chiyoda" required>

                <label>Street Name <span class="required">*</span></label>
                <input type="text" name="receiver_street_name" id="receiver_street_name" placeholder="1-1 Marunouchi" required>

                <label>Apartment No</label>
                <input type="text" name="receiver_apartment_no" id="receiver_apartment_no" placeholder="Apt 101">

                <label>Email <span class="required">*</span></label>
                <input type="email" name="receiver_email" id="receiver_email" placeholder="john.doe@example.com" required>

                <label>Phone <span class="required">*</span></label>
                <input type="text" name="receiver_phone" id="receiver_phone" placeholder="+81 90 1234 5678" required>

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

<script>
document.addEventListener('DOMContentLoaded', function () {
    const checkbox = document.getElementById('sameAsCustomer');

    checkbox.addEventListener('change', function () {
        if (this.checked) {
            document.getElementById('receiver_first_name').value = document.getElementById('customer_first_name').value;
            document.getElementById('receiver_last_name').value = document.getElementById('customer_last_name').value;
            document.getElementById('receiver_email').value = document.getElementById('customer_email').value;
            document.getElementById('receiver_phone').value = document.getElementById('customer_phone').value;
            document.getElementById('receiver_postal_code').value = document.getElementById('postal_code').value;
            document.getElementById('receiver_prefecture').value = document.getElementById('perfecture').value;
            document.getElementById('receiver_city').value = document.getElementById('city').value;
            document.getElementById('receiver_street_name').value = document.getElementById('street_name').value;
            document.getElementById('receiver_apartment_no').value = document.getElementById('apartment_no').value;
        } else {
            document.getElementById('receiver_first_name').value = '';
            document.getElementById('receiver_last_name').value = '';
            document.getElementById('receiver_email').value = '';
            document.getElementById('receiver_phone').value = '';
            document.getElementById('receiver_postal_code').value = '';
            document.getElementById('receiver_prefecture').value = '';
            document.getElementById('receiver_city').value = '';
            document.getElementById('receiver_street_name').value = '';
            document.getElementById('receiver_apartment_no').value = '';
        }
    });
});
</script>

@endsection