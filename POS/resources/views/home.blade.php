@extends('layouts.app')

@section('content')
<!-- Products Section -->
<section class="products" id="productsContainer">
@forelse($items as $item)
<div class="product-card">
    <img src="{{ $item->image ? asset('images/uploads/'.$item->image) : asset('images/no-image.jpg') }}">
    <div class="product-info">
        <h3 class="item-name">{{ $item->item_name }}</h3>
        <p>{{ $item->description ?? 'No description available' }}</p>
        <span>{{ $item->currency }} {{ number_format($item->price,2) }}</span>
        <br><br>
        <button class="orderBtn"
            data-id="{{ $item->id }}"
            data-name="{{ $item->item_name }}"
            data-price="{{ $item->price }}"
            data-desc="{{ $item->description }}"
            data-image="{{ $item->image ? asset('images/uploads/'.$item->image) : asset('images/no-image.jpg') }}">
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
        <img id="popupImage">
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
</script>

<script src="{{ asset('js/home.js') }}"></script>
@endsection