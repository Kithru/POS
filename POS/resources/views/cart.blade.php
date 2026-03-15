@extends('layouts.app')

@section('content')

<h2>Your Cart</h2>
@if(session('cart'))
    @foreach($cart as $item)
        <div class="cart-item">
            <img src="{{ $item['image'] }}" width="80">
            <h3>{{ $item['name'] }}</h3>
            <p>Price: {{ $item['price'] }}</p>
            <p>Qty: {{ $item['quantity'] }}</p>
            <p>Total: {{ $item['price'] * $item['quantity'] }}</p>
        </div>
    @endforeach
@else
    <p>Your cart is empty</p>
@endif

@endsection
