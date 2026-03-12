@extends('layouts.app')

@section('content')

<!-- Menu Section -->
<section class="products">
    <!-- Dish 1 -->
    <div class="product-card">
        <img src="{{ asset('images/restuarant/dish1.webp') }}" alt="Grilled Salmon">
        <div class="product-info">
            <h3>Grilled Salmon</h3>
            <p>Freshly grilled salmon with herbs</p>
            <span>$15.99</span><br><br>
            <button>Order Now</button>
        </div>
    </div>

    <!-- Dish 2 -->
    <div class="product-card">
        <img src="{{ asset('images/restuarant/dish2.jpg') }}" alt="Beef Steak">
        <div class="product-info">
            <h3>Beef Steak</h3>
            <p>Juicy beef steak served with veggies</p>
            <span>$22.99</span><br><br>
            <button>Order Now</button>
        </div>
    </div>

    <!-- Dish 3 -->
    <div class="product-card">
        <img src="{{ asset('images/restuarant/dish3.jpg') }}" alt="Vegetable Pasta">
        <div class="product-info">
            <h3>Vegetable Pasta</h3>
            <p>Delicious pasta with fresh vegetables</p>
            <span>$12.99</span><br><br>
            <button>Order Now</button>
        </div>
    </div>

    <!-- Dish 4 -->
    <div class="product-card">
        <img src="{{ asset('images/restuarant/dish4.webp') }}" alt="Sushi Platter">
        <div class="product-info">
            <h3>Sushi Platter</h3>
            <p>Assorted sushi rolls with fresh fish</p>
            <span>$19.99</span><br><br>
            <button>Order Now</button>
        </div>
    </div>

   

    <!-- Dish 11 -->
    <div class="product-card">
        <img src="{{ asset('images/restuarant/dish11.jpg') }}" alt="Seafood Udon">
        <div class="product-info">
            <h3>Seafood Udon</h3>
            <p>Thick noodles with fresh seafood</p>
            <span>$16.99</span><br><br>
            <button>Order Now</button>
        </div>
    </div>

    <!-- Dish 12 -->
    <div class="product-card">
        <img src="{{ asset('images/restuarant/dish12.webp') }}" alt="Japanese Pancakes">
        <div class="product-info">
            <h3>Japanese Pancakes</h3>
            <p>Fluffy pancakes topped with berries</p>
            <span>$7.99</span><br><br>
            <button>Order Now</button>
        </div>
    </div>
</section>
@endsection