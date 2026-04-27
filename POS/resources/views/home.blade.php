@extends('layouts.app')

@section('content')

<!-- ===================== ADS ===================== -->
<div class="ad-slider">
    <div class="ad-track">
        @for($i = 0; $i < 2; $i++)
            <div class="ad-slide">🔥 Rajarata Sakura Restaurant</div>
            <div class="ad-slide">🎉 Rajarata Sakura Restaurant</div>
            <div class="ad-slide">🔥 Rajarata Sakura Restaurant</div>
            <div class="ad-slide">🎉 Rajarata Sakura Restaurant</div>
        @endfor
    </div>
</div>

<!-- ===================== BANNER ===================== -->
<div class="banner-slider">
    <div class="banner-slide active">
        <img src="{{ asset('images/banners/add01.jpg') }}">
    </div>
    <div class="banner-slide">
        <img src="{{ asset('images/banners/add02.jpg') }}">
    </div>
    <div class="banner-slide">
        <img src="{{ asset('images/banners/add03.jpg') }}">
    </div>

    <button class="banner-arrow left" onclick="prevSlide()">
        <i class="fas fa-chevron-left"></i>
    </button>

    <button class="banner-arrow right" onclick="nextSlide()">
        <i class="fas fa-chevron-right"></i>
    </button>
</div>

<!-- ===================== TOP PRODUCTS ===================== -->
<div class="products-wrapper">
    <div class="scroll-arrow left-arrow">
        <i class="fas fa-chevron-left"></i>
    </div>

    <section class="products" id="productsContainer">
        @forelse($items ?? [] as $item)
            <div class="product-card">
                <img src="{{ $item->image ? asset('images/uploads/'.$item->image) : asset('images/no-image.jpg') }}">

                <div class="product-info">
                    <h3 class="item-name">{{ $item->item_name }}</h3>

                    <span class="product-price">
                        {!! $item->currency_icon ?? '' !!}
                        <!-- {{ number_format($item->price, 2) }} -->
                        {{ number_format($item->price, $item->price == floor($item->price) ? 0 : 2) }}
                    </span>

                    <button class="orderBtn"
                        data-id="{{ $item->item_id }}"
                        data-name="{{ $item->item_name }}"
                        data-price="{{ $item->price }}"
                        data-image="{{ $item->image ? asset('images/uploads/'.$item->image) : asset('images/no-image.jpg') }}"
                        data-desc="{{ $item->description }}"
                        data-currency-icon="{{ $item->currency_icon ?? '' }}">
                        Order Now
                    </button>
                </div>
            </div>
        @empty
            <p>No items available.</p>
        @endforelse
    </section>

    <div class="scroll-arrow right-arrow">
        <i class="fas fa-chevron-right"></i>
    </div>
</div>

<!-- ===================== EXPLORE TITLE ===================== -->
<div style="display: flex; justify-content: center;">
    <h2 class="explore-title">Explore more products</h2>
</div>

<!-- ===================== EXPLORE SECTION ===================== -->
<div class="explore-section" id="exploreSection">
    <div class="explore-container">

        <!-- FILTER -->
        <div class="explore-filter">

            <h3>Filter By Category</h3>

            <div class="category-buttons">
                <a href="{{ route('items.filter', ['category_id' => 'all']) }}"
                   class="category-btn {{ request('category_id') == 'all' ? 'active' : '' }}">
                   All
                </a>

                @foreach($categories ?? [] as $category)
                    <a href="{{ route('items.filter', ['category_id' => $category->category_id]) }}"
                       class="category-btn {{ request('category_id') == $category->category_id ? 'active' : '' }}">
                       {{ $category->category_name }}
                    </a>
                @endforeach
            </div>

            <hr style="margin:15px 0;">

            <!-- PRICE FILTER -->
            <h3>Filter By Price</h3>

            <form class="explore-filter-form" method="GET" action="{{ route('items.filter') }}">
                <input type="hidden" name="category_id" value="{{ request('category_id', 'all') }}">

                <label>Min:</label>
                <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="0" class="price-input">

                <label>Max:</label>
                <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="1000" class="price-input">

                <button type="submit" class="category-btn" style="margin-top:10px;">
                    Apply
                </button>
            </form>

        </div>

        <!-- PRODUCTS GRID -->
        <div class="explore-products">
            <section class="products-grid" id="productsGrid">

                {{-- MAIN GRID (FILTERED / DEFAULT) --}}
                @include('partials.products_grid', ['items' => $exploreItems ?? []])

                {{-- FALLBACK ONLY IF EMPTY --}}
                @if(empty($exploreItems) || count($exploreItems) === 0)
                    @forelse($topItems ?? [] as $item)
                        <div class="product-card">
                            <img src="{{ $item->image ? asset('images/uploads/'.$item->image) : asset('images/no-image.jpg') }}">

                            <div class="product-info">
                                <h3 class="item-name">{{ $item->item_name }}</h3>

                                <span class="product-price">
                                    {!! $item->currency_icon ?? '' !!}
                                    <!-- {{ number_format($item->price, 2) }} -->
                                    {{ number_format($item->price, $item->price == floor($item->price) ? 0 : 2) }}
                                </span>

                                <button class="orderBtn"
                                    data-id="{{ $item->item_id }}"
                                    data-name="{{ $item->item_name }}"
                                    data-price="{{ $item->price }}"
                                    data-image="{{ $item->image ? asset('images/uploads/'.$item->image) : asset('images/no-image.jpg') }}"
                                    data-desc="{{ $item->description }}"
                                    data-currency-icon="{{ $item->currency_icon ?? '' }}">
                                    Order Now
                                </button>
                            </div>
                        </div>
                    @empty
                        <p>No items available.</p>
                    @endforelse
                @endif

            </section>
        </div>

    </div>
</div>

<!-- ===================== ORDER MODAL ===================== -->
<div id="orderModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>

        <img id="popupImage">
        <h2 id="popupName"></h2>
        <p id="popupDesc"></p>
        <h3 id="popupPrice"></h3>

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
</script>

<script src="{{ asset('js/home.js') }}"></script>

<script>
function formatPrice(price) {
    price = Number(price);
    return price % 1 === 0 ? price.toLocaleString() : price.toLocaleString(undefined, {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
}

document.addEventListener('DOMContentLoaded', function() {

    const filterForm = document.querySelector('.explore-filter-form');

    if(filterForm){
        filterForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(filterForm);
            const url = filterForm.action;

            fetch(url + '?' + new URLSearchParams(formData), {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.text())
            .then(html => {
                document.querySelector('#productsGrid').innerHTML = html;
                document.getElementById('exploreSection').scrollIntoView({ behavior: 'smooth' });
            })
            .catch(err => console.error(err));
        });
    }

});
</script>

@endsection