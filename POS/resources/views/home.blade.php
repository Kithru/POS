@extends('layouts.app')

@section('content')

<!-- Menu Section -->
<section class="products">
    @forelse($items as $item)
        <div class="product-card">
            {{-- Show full uploaded image --}}
            @if($item->image)
                <img src="{{ asset('images/uploads/' . $item->image) }}" alt="{{ $item->item_name }}">
            @else
                <img src="{{ asset('images/no-image.jpg') }}" alt="{{ $item->item_name }}">
            @endif

            <div class="product-info">
                <h3>{{ $item->item_name }}</h3>
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