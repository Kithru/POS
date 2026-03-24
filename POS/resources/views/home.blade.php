@extends('layouts.app')

@section('content')

<div class="ad-slider">
    <div class="ad-track">
        <div class="ad-slide">🔥 20% OFF on All Items Today!</div>
        <div class="ad-slide">🍣 Fresh Sushi Available Now!</div>
        <div class="ad-slide">🚚 Free Delivery for Orders Over 5000</div>
        <div class="ad-slide">🎉 Special Combo Offers This Week</div>
        <!-- ...................................................................... -->
        <div class="ad-slide">🔥 20% OFF on All Items Today!</div>
        <div class="ad-slide">🍣 Fresh Sushi Available Now!</div>
        <div class="ad-slide">🚚 Free Delivery for Orders Over 5000</div>
        <div class="ad-slide">🎉 Special Combo Offers This Week</div>
    </div>
</div>

<!-- Image Banner Slider -->
<div class="banner-slider">
    <div class="banner-slide active">
        <img src="{{ asset('images/banners/add01.jpg') }}" alt="Banner 1">
    </div>
    <div class="banner-slide">
        <img src="{{ asset('images/banners/add02.jpg') }}" alt="Banner 2">
    </div>
    <div class="banner-slide">
        <img src="{{ asset('images/banners/add03.jpg') }}" alt="Banner 3">
    </div>

    <button class="banner-arrow left" onclick="prevSlide()">
    <i class="fas fa-chevron-left"></i>
    </button>

    <button class="banner-arrow right" onclick="nextSlide()">
        <i class="fas fa-chevron-right"></i>
    </button>
</div>

<!-- Products Section -->
<section class="products" id="productsContainer">
@forelse($items as $item)
    <div class="product-card">
        <!-- Product Image -->
        <img src="{{ $item->image ? asset('images/uploads/'.$item->image) : asset('images/no-image.jpg') }}" alt="{{ $item->item_name }}">
        
        <div class="product-info">
            <h3 class="item-name">{{ $item->item_name }}</h3>
            <p>{{ $item->description ?? 'No description available' }}</p>
            <!-- Product Price with Currency Icon -->
            <span class="product-price">
                {!! $item->currency_icon ?? '' !!} {{ number_format($item->price, 2) }}
            </span>
            <br><br>
            
            <!-- Order Button -->
            <button class="orderBtn"
                data-id="{{ $item->item_id }}"
                data-name="{{ $item->item_name }}"
                data-price="{{ $item->price }}"
                data-desc="{{ $item->description ?? '' }}"
                data-image="{{ $item->image ? asset('images/uploads/'.$item->image) : asset('images/no-image.jpg') }}"
                data-currency-icon='{!! $item->currency_icon ?? "" !!}'>
                Order Now
            </button>
        </div>
    </div>
@empty
    <p>No items available.</p>
@endforelse
</section>

<!-- ORDER POPUP -->
<div id="orderModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <img id="popupImage" alt="Product Image">
        <h2 id="popupName"></h2>
        <p id="popupDesc"></p>
        <h3 id="popupPrice"></h3>

        <!-- Quantity -->
        <div class="qty-box">
            <button id="minus">-</button>
            <input type="text" id="qty" value="1" readonly>
            <button id="plus">+</button>
        </div>
        <br>
        <button class="addCartBtn">Add To Cart</button>
    </div>
</div>

@endsection

@section('scripts')
<script>
const CART_ADD_URL = "{{ route('cart.add') }}";

// Banner Auto Slide (3 seconds)
let slides = document.querySelectorAll('.banner-slide');
let currentSlide = 0;

function showSlide(index) {
    slides.forEach((slide, i) => {
        slide.classList.remove('active');
    });
    slides[index].classList.add('active');
}

// Auto change every 5 seconds
setInterval(() => {
    currentSlide++;
    if (currentSlide >= slides.length) {
        currentSlide = 0;
    }
    showSlide(currentSlide);
}, 5000);

function nextSlide() {
    currentSlide++;
    if (currentSlide >= slides.length) {
        currentSlide = 0;
    }
    showSlide(currentSlide);
}

function prevSlide() {
    currentSlide--;
    if (currentSlide < 0) {
        currentSlide = slides.length - 1;
    }
    showSlide(currentSlide);
}

// Category filtering
const categoryButtons = document.querySelectorAll('.category-btn');
const productCards = document.querySelectorAll('.product-card');

categoryButtons.forEach(btn => {
    btn.addEventListener('click', () => {
        // Remove active class from all buttons
        categoryButtons.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        const category = btn.getAttribute('data-category');

        productCards.forEach(card => {
            if (category === 'all' || card.getAttribute('data-category') === category) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });
});

</script>
<script src="{{ asset('js/home.js') }}"></script>
@endsection