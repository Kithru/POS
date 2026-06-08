<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Rajarata Sakura POS</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="{{ asset('css/pos.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
</head>

<body class="light">

<div class="pos-container">

    {{-- ================= LEFT SIDEBAR ================= --}}
    <aside class="sidebar">

        <div class="logo">
            <h2>Rajarata Sakura POS</h2>

            <button id="themeToggle" class="theme-toggle">
                <i class="fa fa-moon"></i>
            </button>
        </div>

        <div class="category-list">

            <button class="category-btn active-category" data-category="all">
                <i class="fa fa-border-all"></i> All Items
            </button>

            @foreach($categories as $category)
                <button class="category-btn" data-category="{{ $category->category_id }}">
                    {{ $category->category_name }}
                </button>
            @endforeach

        </div>

    </aside>

    {{-- ================= CENTER PRODUCTS ================= --}}
    <main class="main-content">

        <div class="top-bar">
            <div class="search-box">
                <i class="fa fa-search"></i>
                <input type="text" id="search" placeholder="Search menu item...">
            </div>
        </div>

        <div class="products-grid">

            @foreach($items as $item)

                <div class="product-card"
                     data-category="{{ $item->category_id }}"
                     data-name="{{ strtolower($item->item_name) }}">

                    <div class="product-image">
                        <img src="{{ $item->image
                            ? asset('images/uploads/'.$item->image)
                            : asset('images/no-image.jpg') }}"
                             alt="{{ $item->item_name }}">
                    </div>

                    <div class="product-info">
                        <h3>{{ $item->item_name }}</h3>

                        <div class="price-tag">
                            ¥ {{ number_format($item->price,0) }}
                        </div>
                    </div>

                    <button class="add-cart-btn"
                            data-id="{{ $item->item_id }}"
                            data-name="{{ $item->item_name }}"
                            data-price="{{ $item->price }}"
                            data-qty="{{ $item->quantity }}"
                            data-countable="{{ $item->countable }}">
                        <i class="fa fa-plus"></i>
                    </button>

                </div>

            @endforeach

        </div>

    </main>

    {{-- ================= RIGHT CART ================= --}}
    <aside class="cart-section">

        <div class="cart-header">
            <div>Current Order</div>
            <span class="cart-badge" id="cartCount">0</span>
        </div>

        <div class="cart-items" id="cartItems"></div>

        <div class="cart-footer">

            <div class="cart-total">
                <span>Total</span>
                <span>¥ <span id="cartTotal">0</span></span>
            </div>

            <button class="checkout-btn">
                <i class="fa fa-check"></i> Place Order
            </button>

        </div>

    </aside>

</div>

{{-- ================= CHECKOUT MODAL ================= --}}
<div id="checkoutModal" class="modal">

    <div class="modal-content">

        <div class="modal-header">
            <h2>Order Confirmation</h2>
            <span class="close-modal">&times;</span>
        </div>

        {{-- ORDER TYPE --}}
        <div class="form-group">
            <label>Order Type</label>

            <div class="toggle-group">
                <button type="button" class="toggle-btn active" id="popupTakeAway">
                    Take Away
                </button>

                <button type="button" class="toggle-btn" id="popupDineIn">
                    Dine In
                </button>
            </div>
        </div>

        {{-- CUSTOMER --}}
        <div class="form-group">
            <label>Customer Name</label>
            <input type="text" id="customerName" placeholder="Enter customer name">
        </div>

        <div class="form-group">
            <label>Mobile Number</label>
            <input type="text" id="customerMobile" placeholder="Enter mobile number">
        </div>

        {{-- ITEMS --}}
        <div class="order-items">
            <h3>Items</h3>
            <div id="popupItemList"></div>
        </div>

        {{-- TOTAL --}}
        <div class="popup-total">
            <span>Total Amount</span>
            <span>¥ <span id="popupTotal">0</span></span>
        </div>

        {{-- PAYMENT --}}
        <div class="form-group">
            <label>Payment Status</label>

            <div class="payment-toggle">

                <button type="button" class="payment-btn active" data-payment="paid">
                    Pay Now
                </button>

                <button type="button" class="payment-btn" data-payment="later">
                    Pay Later
                </button>

            </div>
        </div>

        {{-- SUBMIT --}}
        <button class="confirm-order-btn">
            <i class="fa fa-plus"></i> Add Order
        </button>

    </div>

</div>

<script src="{{ asset('js/pos.js') }}"></script>

</body>
</html>