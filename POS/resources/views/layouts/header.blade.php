<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<header class="header">

    <!-- TOP BAR -->
    <div class="header-top">
        <!-- LEFT: LOCATION -->
        <div class="header-left">
            <a href="{{ route('home') }}">
                <img src="{{ asset('images/logo.png') }}" alt="Company Logo" class="logo">
            </a>
        </div>

        <!-- CENTER: SEARCH -->
        <div class="search-wrapper">
            <form action="{{ route('item.search') }}" method="GET" class="search-form">
                <input type="text" id="searchInput" name="query"
                    placeholder="Find product..."
                    value="{{ request('query') }}" autocomplete="off">
                <button type="submit" class="search-btn"><i class="fas fa-search"></i></button>
                <span class="clear-btn" id="clearSearch">✕</span>
            </form>
        </div>

        <!-- RIGHT: ACTION ICONS -->
        <div class="header-right">
            <a href="{{ route('cart.index') }}" class="cart-wrapper" title="My Cart">
                <i class="fas fa-shopping-cart"></i>
                <span class="cart-count" id="cartCount">
                    {{ session('cart') ? count(session('cart')) : 0 }}
                </span>
            </a>

            <a href="{{ route('login.post') }}" class="header-icon" title="Sign In">
                <i class="fas fa-user"></i>
            </a>
        </div>

    </div>

    <!-- NAVIGATION BAR -->
    <div class="nav-wrapper">
        <nav class="nav-menu">
            <div class="nav-dropdown" id="categoryDropdown">
                 <span class="nav-link dropdown-toggle">
        Categories
        <i class="fas fa-chevron-down dropdown-icon"></i> <!-- added icon -->
    </span>
                <div class="dropdown-menu" id="dropdownMenu">
                    @foreach($categories as $category)
                        <a href="{{ route('items.byCategory', $category->category_id) }}">
                            {{ $category->category_name }}
                        </a>
                    @endforeach
                </div>
            </div>
            <!-- Example other nav links -->
            <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
            <a href="{{ route('about') }}" class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}">About</a>
            <a href="{{ route('order.track') }}" class="nav-link {{ request()->routeIs('order.track') ? 'active' : '' }}">Track Order</a>
        </nav>
    </div>

</header>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // CLEAR SEARCH
    const clearBtn = document.getElementById("clearSearch");
    const searchInput = document.getElementById("searchInput");
    if (clearBtn && searchInput) {
        clearBtn.addEventListener("click", () => {
            searchInput.value = "";
            searchInput.focus();
        });
    }
    

    // DROPDOWN TOGGLE
    const dropdown = document.getElementById("categoryDropdown");
    const menu = document.getElementById("dropdownMenu");
    dropdown.addEventListener("click", function (e) {
        e.stopPropagation();
        menu.classList.toggle("show");
        dropdown.classList.toggle("open");
    });
    menu.addEventListener("click", function (e) { e.stopPropagation(); });
    document.addEventListener("click", function () { menu.classList.remove("show"); });

    // CART COUNT UPDATE
    window.updateCartCount = function(count) {
        const el = document.getElementById("cartCount");
        if (el) el.textContent = count;
    };
});
</script>