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

    <!-- LEFT -->
    <aside class="sidebar">
        <div class="logo">
            <h2>Rajarata Sakura POS</h2>
            <button id="themeToggle" class="theme-toggle">
                <i class="fa fa-moon"></i>
            </button>
        </div>

        <div class="category-list">
            <button class="category-btn active-category" data-category="all">
                <i class="fa fa-border-all"></i>
                All Items
            </button>
            @foreach($categories as $category)
                <button class="category-btn"
                        data-category="{{ $category->category_id }}">
                    {{ $category->category_name }}
                </button>
            @endforeach
        </div>
    </aside>

    <!-- CENTER -->
    <main class="main-content">
        <div class="top-bar" style="margin-top:17px;">
            <div class="search-box">
                <i style="margin-left:860px; margin-top:-5px;" class="fa fa-search"></i>
                <input type="text" id="search" placeholder="Search menu item...">
            </div>
        </div>

        <div class="products-grid" id="productsGrid">
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


    <!-- RIGHT -->
    <aside class="cart-section">
        <div class="cart-header">
            <div>
                Current Order
            </div>
            <span class="cart-badge" id="cartCount"> 0 </span>
        </div>

        <div class="cart-order-options">
            <input type="hidden" id="orderType" value="take_away">
            <div class="order-type-buttons">
                <button class="order-type-btn active" id="takeAwayBtn">
                    <i class="fa fa-motorcycle"></i>
                    Take Away
                </button>

                <button class="order-type-btn" id="dineInBtn">
                    <i class="fa fa-utensils"></i>
                    Dine In
                </button>
            </div>

            <div id="tableSection" style="display:none">
                <select id="tableSelect"
                        class="table-select">
                    <option value="">
                        Select Table
                    </option>
                    @foreach($tables as $table)
                        @if($table->availability == 0)
                            <option value="{{ $table->id }}">
                                Table {{ $table->table_number }}
                            </option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>

        <div class="cart-items" id="cartItems">
        </div>

        <div class="cart-footer">
            <div class="cart-total">
                <span>Total</span>
                <span>
                    ¥ <span id="cartTotal">0</span>
                </span>
            </div>

            <button class="checkout-btn">
                <i class="fa fa-check"></i>
                Place Order
            </button>
        </div>
    </aside>

</div>


<script src="{{ asset('js/pos.js') }}"></script>

</body>
</html>