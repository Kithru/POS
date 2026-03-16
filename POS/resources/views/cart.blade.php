@extends('layouts.app')

@section('content')

<div class="cart-container">

```
<h2 class="cart-title">🛒 Your Cart</h2>

@if($cart && count($cart) > 0)

    <div class="cart-items">

        @foreach($cart as $id => $item)

            <div class="cart-card">

                <img src="{{ $item['image'] }}" class="cart-img" alt="{{ $item['name'] }}">

                <div class="cart-info">

                    <h3>{{ $item['name'] }}</h3>

                    <p class="price">Rs {{ $item['price'] }}</p>

                    <div class="qty-box">

                        <button class="qty-btn minus" data-id="{{ $id }}">−</button>

                        <input 
                            type="text"
                            value="{{ $item['quantity'] }}"
                            class="qty-input"
                            data-id="{{ $id }}"
                        >

                        <button class="qty-btn plus" data-id="{{ $id }}">+</button>

                    </div>

                    <p class="item-total">
                        Total: Rs 
                        <span id="total-{{ $id }}">
                            {{ $item['price'] * $item['quantity'] }}
                        </span>
                    </p>

                    <button class="remove-btn" data-id="{{ $id }}">
                        Remove
                    </button>

                </div>

            </div>

        @endforeach

    </div>

    <div class="cart-summary">

        <h3>Cart Total</h3>

        <p>
            Rs 
            <span id="cartTotal">
                {{ collect($cart)->sum(function($item){
                    return $item['price'] * $item['quantity'];
                }) }}
            </span>
        </p>

        <button class="checkout-btn">
            Proceed to Checkout
        </button>

    </div>

@else

    <p class="empty-cart">Your cart is empty</p>

@endif
```

</div>

@endsection
