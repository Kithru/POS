@extends('layouts.app')

@section('content')

<!-- Hero Section (Slideshow) -->
<section class="hero">
    <div class="slideshow-container">
        <div class="slide fade">
            <img src="{{ asset('images/slide1.jpg') }}" alt="Slide 1">
            <div class="hero-content">
                <h2>Welcome to Rajarata Sakura Restaurant</h2>
                <p>Experience authentic flavors and delicious meals</p>
                <a href="#">Reserve a Table</a>
            </div>
        </div>
        <div class="slide fade">
            <img src="{{ asset('images/slide2.jpg') }}" alt="Slide 2">
            <div class="hero-content">
                <h2>Fresh & Delicious</h2>
                <p>Discover our chef's special dishes</p>
                <a href="#">View Menu</a>
            </div>
        </div>
        <div class="slide fade">
            <img src="{{ asset('images/slide3.jpg') }}" alt="Slide 3">
            <div class="hero-content">
                <h2>Authentic Japanese Cuisine</h2>
                <p>Enjoy the true taste of Japan</p>
                <a href="#">Book Now</a>
            </div>
        </div>
    </div>
</section>

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

    <!-- Dish 5 -->
    <div class="product-card">
        <img src="{{ asset('images/restuarant/dish5.jpg') }}" alt="Tempura">
        <div class="product-info">
            <h3>Tempura</h3>
            <p>Crispy fried shrimp and vegetables</p>
            <span>$13.99</span><br><br>
            <button>Order Now</button>
        </div>
    </div>

    <!-- Dish 6 -->
    <div class="product-card">
        <img src="{{ asset('images/restuarant/dish6.jpg') }}" alt="Ramen">
        <div class="product-info">
            <h3>Ramen</h3>
            <p>Rich pork broth ramen with noodles and eggs</p>
            <span>$11.99</span><br><br>
            <button>Order Now</button>
        </div>
    </div>

    <!-- Dish 7 -->
    <div class="product-card">
        <img src="{{ asset('images/restuarant/dish7.jpg') }}" alt="Teriyaki Chicken">
        <div class="product-info">
            <h3>Teriyaki Chicken</h3>
            <p>Grilled chicken with teriyaki sauce</p>
            <span>$14.99</span><br><br>
            <button>Order Now</button>
        </div>
    </div>

    <!-- Dish 8 -->
    <div class="product-card">
        <img src="{{ asset('images/restuarant/dish8.jpg') }}" alt="Miso Soup">
        <div class="product-info">
            <h3>Miso Soup</h3>
            <p>Traditional Japanese miso soup</p>
            <span>$5.99</span><br><br>
            <button>Order Now</button>
        </div>
    </div>

    <!-- Dish 9 -->
    <div class="product-card">
        <img src="{{ asset('images/restuarant/dish9.webp') }}" alt="Chocolate Dessert">
        <div class="product-info">
            <h3>Chocolate Dessert</h3>
            <p>Rich chocolate dessert with cream</p>
            <span>$6.99</span><br><br>
            <button>Order Now</button>
        </div>
    </div>

    <!-- Dish 10 -->
    <div class="product-card">
        <img src="{{ asset('images/restuarant/dish10.webp') }}" alt="Matcha Ice Cream">
        <div class="product-info">
            <h3>Matcha Ice Cream</h3>
            <p>Creamy Japanese green tea ice cream</p>
            <span>$4.99</span><br><br>
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