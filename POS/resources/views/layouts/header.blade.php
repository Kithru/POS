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
            <a href="{{ route('cart.index') }}">
                🛒
                <span class="cart-count">
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
        <li><a href="{{ route('login.post') }}">Login</a></li>
    </ul>
</nav>

<script>

document.addEventListener("DOMContentLoaded", function(){

    // Sidebar
    const menuBtn = document.getElementById("menuBtn");
    const sideMenu = document.getElementById("sideMenu");
    const closeMenu = document.getElementById("closeMenu");

    if(menuBtn){
        menuBtn.onclick = () => {
            sideMenu.style.left = "0";
        };
    }

    if(closeMenu){
        closeMenu.onclick = () => {
            sideMenu.style.left = "-260px";
        };
    }

    // Clear search
    const clearBtn = document.getElementById("clearSearch");
    const searchInput = document.getElementById("searchInput");

    if(clearBtn){
        clearBtn.onclick = () => {
            searchInput.value = "";
            searchInput.focus();
        };
    }

});

</script>