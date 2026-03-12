@extends('layouts.app')

@section('content')

<!-- Menu Section -->
<section class="products" id="productsContainer">
    @forelse($items as $item)
        <div class="product-card">
            @if($item->image)
                <img src="{{ asset('images/uploads/' . $item->image) }}" alt="{{ $item->item_name }}">
            @else
                <img src="{{ asset('images/no-image.jpg') }}" alt="{{ $item->item_name }}">
            @endif

            <div class="product-info">
                <h3 class="item-name">{{ $item->item_name }}</h3>
                <p>{{ $item->description ?? 'No description available' }}</p>
                <span>{{ $item->currency }} {{ number_format($item->price, 2) }}</span><br><br>
                <button>Order Now</button>
            </div>
        </div>
    @empty
        <p>No items available.</p>
    @endforelse
</section>

@endsection

@section('scripts')
<script>
const searchInput = document.getElementById('searchInput');
const productCards = document.querySelectorAll('#productsContainer .product-card');

searchInput.addEventListener('input', function() {
    const query = this.value.toLowerCase();

    productCards.forEach(card => {
        const name = card.querySelector('.item-name').textContent.toLowerCase();
        if(name.includes(query)) {
            card.style.display = 'flex'; // show matching item
        } else {
            card.style.display = 'none'; // hide non-matching
        }
    });
});
</script>
@endsection