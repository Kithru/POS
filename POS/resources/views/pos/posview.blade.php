<!DOCTYPE html>
<html>
<head>
    <title>Rajarata Sakura POS</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="{{ asset('css/pos.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
</head>

<body class="light">

<div class="pos-container">

    <!-- ================= SIDEBAR ================= -->
    <div class="sidebar">

        <div class="logo">
            Rajarata Sakura POS

            <button id="themeToggle" class="theme-toggle">
                <i class="fa fa-moon"></i>
            </button>

        </div>

        <input type="text" id="search" placeholder="Search items...">

        <div class="category-list">

            @foreach($categories as $category)
                <button class="category-btn"
                        data-category="{{ $category->category_id }}">
                    {{ $category->category_name }}
                </button>
            @endforeach

        </div>

    </div>

    <!-- ================= PRODUCTS ================= -->
    <div class="products-section">

        <div class="products-grid" id="productsGrid">

            @foreach($items as $item)

                <div class="product-card"
                     data-category="{{ $item->category_id }}"
                     data-name="{{ strtolower($item->item_name) }}">

                    <div class="product-image">
                        <img src="{{ asset($item->image) }}" alt="">
                    </div>

                    <div class="product-info">
                        <h3>{{ $item->item_name }}</h3>

                        <!-- FIXED: Rs → ¥ -->
                        <p>¥ {{ number_format($item->price, 0) }}</p>
                    </div>

                    <button class="add-cart-btn"
                            data-id="{{ $item->item_id }}"
                            data-name="{{ $item->item_name }}"
                            data-price="{{ $item->price }}">

                        <i class="fa fa-cart-plus"></i> Add

                    </button>

                </div>

            @endforeach

        </div>

    </div>

    <!-- ================= CART ================= -->
    <div class="cart-section">

        <div class="cart-header">
            <i class="fa fa-shopping-cart"></i> Item List
        </div>

        <div class="cart-items" id="cartItems"></div>

        <div class="cart-footer">

            <h3>
                Total: ¥ <span id="cartTotal">0</span>
            </h3>

            <button class="checkout-btn">
                Checkout
            </button>

        </div>

    </div>

</div>

<script src="{{ asset('js/pos.js') }}"></script>

</body>
</html>