@forelse($items as $item)
<div class="product-card">

    <img src="{{ $item->image ? asset('images/uploads/'.$item->image) : asset('images/no-image.jpg') }}">

    <div class="product-info">

        <h3 class="item-name">{{ $item->item_name }}</h3>

        <span class="product-price">
            {!! $item->currency_icon ?? '' !!}
            {{ number_format($item->price, 2) }}
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