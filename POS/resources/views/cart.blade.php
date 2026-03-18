@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{ asset('css/cart.css') }}">

<div class="cart-container">

    <h2 class="cart-title">🛒 Your Cart</h2>

    @if($cart && count($cart) > 0)

    <div class="cart-items">

        @foreach($cart as $id => $item)

        <div class="cart-card">

            <!-- Product Image -->
            <img src="{{ $item['image'] }}" class="cart-img" alt="{{ $item['name'] }}">

            <!-- Product Info -->
            <div class="cart-info">

                <h3>{{ $item['name'] }}</h3>

                <p class="desc">
                    {{ $item['description'] ?? 'No description available' }}
                </p>

                <!-- Price -->
                <p class="price">
                    <span class="currency-icon">
                        {{ $item['currency_icon'] ?? '' }}
                    </span>
                    {{ number_format($item['price'], 2) }}
                </p>

                <!-- Quantity -->
                <div class="qty-box">
                    <button class="qty-btn minus" data-id="{{ $id }}">−</button>
                    <input type="text" value="{{ $item['quantity'] }}" class="qty-input" data-id="{{ $id }}" readonly >
                    <button class="qty-btn plus" data-id="{{ $id }}">+</button>
                </div>

                <!-- Item Total -->
                <p class="item-total">
                    Total:
                    <span class="currency-icon"> {{ $item['currency_icon'] ?? '' }} </span>
                    <span id="total-{{ $id }}"> {{ number_format($item['price'] * $item['quantity'], 2) }} </span>
                </p>

                <!-- Remove -->
                <button class="remove-btn" data-id="{{ $id }}">
                    Remove
                </button>
            </div>

        </div>

        @endforeach

    </div>

    <!-- Cart Summary -->
    <div class="cart-summary">

        <h3>Cart Total</h3>

        <p>
            <span class="currency-icon">
                {{ collect($cart)->first()['currency_icon'] ?? '' }}
            </span>

            <span id="cartTotal">
                {{ number_format(collect($cart)->sum(function($item){
                    return $item['price'] * $item['quantity'];
                }), 2) }}
            </span>
        </p>

        <button class="checkout-btn">
            Proceed to Checkout
        </button>

    </div>

    @else

    <p class="empty-cart">Your cart is empty</p>

    @endif

</div>

@endsection


@section('scripts')

<script>
const UPDATE_CART_URL = "{{ url('/cart/update') }}";
const REMOVE_CART_URL = "{{ url('/cart/remove') }}";

const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

/* -------- INCREASE -------- */
document.querySelectorAll(".plus").forEach(btn => {
    btn.addEventListener("click", function(){
        let id = this.dataset.id;
        let input = document.querySelector(`.qty-input[data-id='${id}']`);
        let qty = parseInt(input.value) + 1;
        updateCart(id, qty);
    });
});

/* -------- DECREASE -------- */
document.querySelectorAll(".minus").forEach(btn => {
    btn.addEventListener("click", function(){
        let id = this.dataset.id;
        let input = document.querySelector(`.qty-input[data-id='${id}']`);
        let qty = parseInt(input.value);

        if(qty > 1){
            qty--;
            updateCart(id, qty);
        }
    });
});

/* -------- UPDATE CART -------- */
function updateCart(id, qty){
    fetch(UPDATE_CART_URL,{
        method:"POST",
        headers:{
            "Content-Type":"application/json",
            "X-CSRF-TOKEN":token
        },
        body:JSON.stringify({
            id:id,
            quantity:qty
        })
    })
    .then(res => res.json())
    .then(data => {
        if(data.success){
            location.reload();
        }
    });
}

/* -------- REMOVE ITEM -------- */
document.querySelectorAll(".remove-btn").forEach(btn => {
    btn.addEventListener("click", function(){
        let id = this.dataset.id;

        fetch(REMOVE_CART_URL,{
            method:"POST",
            headers:{
                "Content-Type":"application/json",
                "X-CSRF-TOKEN":token
            },
            body:JSON.stringify({ id:id })
        })
        .then(res => res.json())
        .then(data => {
            if(data.success){
                location.reload();
            }
        });
    });
});
</script>

@endsection