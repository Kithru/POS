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

                <button class="orderBtn"
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

<script>

const modal = document.getElementById("orderModal");
const orderBtns = document.querySelectorAll(".orderBtn");
const closeBtn = document.querySelector(".close");

const popupName = document.getElementById("popupName");
const popupDesc = document.getElementById("popupDesc");
const popupPrice = document.getElementById("popupPrice");
const popupImage = document.getElementById("popupImage");

const qtyInput = document.getElementById("qty");

orderBtns.forEach(btn => {

    btn.addEventListener("click", function(){

        popupName.textContent = this.dataset.name;
        popupDesc.textContent = this.dataset.desc;
        popupPrice.textContent = "Price : " + this.dataset.price;
        popupImage.src = this.dataset.image;

        modal.style.display = "flex";
    });

});

closeBtn.onclick = function(){
    modal.style.display = "none";
}

window.onclick = function(e){
    if(e.target == modal){
        modal.style.display = "none";
    }
}


// quantity buttons
document.getElementById("plus").onclick = function(){
    qtyInput.value = parseInt(qtyInput.value) + 1;
}

document.getElementById("minus").onclick = function(){
    if(qtyInput.value > 1){
        qtyInput.value = parseInt(qtyInput.value) - 1;
    }
}

</script>

@endsection
