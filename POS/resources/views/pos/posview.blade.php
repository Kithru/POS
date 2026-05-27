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

    <div class="sidebar">

        <div class="logo">
            Rajarata Sakura POS
            <button id="themeToggle" class="theme-toggle">
                <i class="fa fa-moon"></i>
            </button>
        </div>

        <input type="text" id="search" placeholder="Search items...">

        <div class="category-list">
            <button class="category-btn active-category"
                    data-category="all">
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
    </div>


    <div class="products-section">

        <div class="products-grid"
             id="productsGrid">

            @foreach($items as $item)
                <div class="product-card"
                     data-category="{{ $item->category_id }}"
                     data-name="{{ strtolower($item->item_name) }}">
                    <div class="product-image">
                        <img src="{{ $item->image
                                    ? asset('images/uploads/'.$item->image)
                                    : asset('images/no-image.jpg') }}"  alt="{{ $item->item_name }}">

                    </div>

                    <div class="product-info">
                        <h3> {{ $item->item_name }} </h3>
                        <p> ¥ {{ number_format($item->price, 0) }}</p>
                    </div>

                    <button class="add-cart-btn"
                            data-id="{{ $item->item_id }}" data-name="{{ $item->item_name }}"
                            data-price="{{ $item->price }}" data-qty="{{ $item->quantity }}" data-countable="{{ $item->countable }}">

                        <i class="fa fa-cart-plus"></i> Add
                    </button>
                </div>
            @endforeach
        </div>

    </div>


    <div class="cart-section">

        <div class="cart-header">
            <div class="cart-header-title">
                <i class="fa fa-shopping-cart"></i>
                Item List
            </div>

            <span class="cart-badge" id="cartCount">
                0
            </span>

        </div>


        <div class="cart-items" id="cartItems">

        </div>


        <div class="cart-footer">

            <div class="order-type-section">

                <label class="section-label">Order Type</label>
                <input type="hidden" id="orderType" value="take_away">
                <div class="order-type-buttons">

                    <button type="button"
                            class="order-type-btn active"
                            id="takeAwayBtn">
                        <i class="fa fa-motorcycle"></i> Take Away
                    </button>

                    <button type="button"
                            class="order-type-btn"
                            id="dineInBtn">
                        <i class="fa fa-utensils"></i> Dine In
                    </button>
                </div>

                <!-- TABLE SECTION -->
                <div id="tableSection" style="display:none; margin-top:10px;">
                    <label class="section-label">Select Table</label>

                    <select id="tableSelect" name="table_id" class="table-select">
                        <option value="">-- Select Table --</option>

                        @foreach($tables as $table)
                            @if($table->availability == 0)
                                <option value="{{ $table->id }}">
                                    Table {{ $table->table_number }}
                                    @if($table->max_pax)
                                        ({{ $table->max_pax }} Pax)
                                    @endif
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>

            </div>

            <div class="cart-total">
                <span>
                    Total
                </span>

                <span>
                    ¥ <span id="cartTotal">0</span>
                </span>
            </div>

            <button class="checkout-btn" id="checkoutBtn">

                <i class="fa fa-check-circle"></i>
                Place Order
            </button>
        </div>
    </div>
</div>


<script src="{{ asset('js/pos.js') }}"></script>

</body>
</html>