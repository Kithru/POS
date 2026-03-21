<header class="header">
    <div class="container">

        <!-- Hamburger -->
        <div class="hamburger" id="menuBtn">
            <span></span>
            <span></span>
            <span></span>
        </div>

        <!-- Logo -->
        <h1 class="logo">
            <span class="logo-full">Rajarata Sakura</span>
            <span class="logo-short">RS</span>
        </h1>

        <!-- Search -->
        <div class="search-center">
            <form action="{{ route('item.search') }}" method="GET" style="display:flex; width:100%;">
                <input type="text" id="searchInput" name="query" placeholder="Search Items ..." value="{{ request('query') }}">
                <span class="clear-btn" id="clearSearch">✕</span>
            </form>
        </div>

        <!-- Cart -->
        <div class="cart-icon">
            <a href="{{ route('cart.index') }}" class="cart-link">
                🛒
                <span class="cart-count-badge" id="cartCount">
                    {{ session('cart') ? count(session('cart')) : 0 }}
                </span>
            </a>
        </div>

    </div>
</header>

<!-- SIDE MENU -->
<nav class="side-menu" id="sideMenu">
    <div class="close-btn" id="closeMenu">
        <i class="fa fa-times"></i>
    </div>
    <ul>
        <li><a href="/">Home</a></li>
        <li><a href="#">Restaurant</a></li>
        <li><a href="#">Grocery</a></li>
        <li><a href="#">About</a></li>
        <li><a href="#">Contact</a></li>
        <li><a href="{{ route('order.track') }}">Track My Order</a></li> 
        <li><a href="{{ route('login.post') }}">Login</a></li>
    </ul>
</nav>

<script>
document.addEventListener("DOMContentLoaded", function() {

    // ----- SIDEBAR MENU -----
    const menuBtn = document.getElementById("menuBtn");
    const sideMenu = document.getElementById("sideMenu");
    const closeMenu = document.getElementById("closeMenu");

    if (menuBtn && sideMenu) {
        menuBtn.addEventListener("click", () => {
            sideMenu.style.left = "0"; // open menu
        });
    }

    if (closeMenu && sideMenu) {
        closeMenu.addEventListener("click", () => {
            sideMenu.style.left = "-260px"; // close menu
        });
    }

    // ----- CLEAR SEARCH -----
    const clearBtn = document.getElementById("clearSearch");
    const searchInput = document.getElementById("searchInput");

    if (clearBtn && searchInput) {
        clearBtn.addEventListener("click", () => {
            searchInput.value = "";
            searchInput.focus();
        });
    }

    // ----- CART COUNT -----
    const cartCountEl = document.getElementById("cartCount");
    const cartLink = document.querySelector(".cart-link");

    function updateCartCount(count) {
        if (cartCountEl) {
            cartCountEl.textContent = count;
        }
    }
    window.updateCartCount = updateCartCount;

    // ----- CART CLICK BEHAVIOR -----
    if (cartLink && cartCountEl) {
        cartLink.addEventListener("click", function(e) {
            const count = parseInt(cartCountEl.textContent) || 0;
            if (count === 0) {
                e.preventDefault(); // stop going to cart page
                window.location.href = "/"; // redirect to home page
            }
        });
    }

});
</script>