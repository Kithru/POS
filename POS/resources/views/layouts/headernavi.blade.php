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
            <span class="logo-full">Rajarata Sakura Restaurant</span>
            <span class="logo-short">RSR</span>
        </h1>

    </div>
</header>

<!-- SIDE MENU -->
<nav class="side-menu" id="sideMenu">
    <div class="close-btn" id="closeMenu">
        <i class="fa fa-times"></i>
    </div>
    <ul>
        <li><a href="{{ route('home') }}">Home</a></li>
        @if(isset($categories) && $categories->count() > 0)
            @foreach($categories as $category)
                @if($category->category_id) {{-- Safety check --}}
                    <li>
                        <a href="{{ route('items.byCategory', $category->category_id) }}">
                            {{ $category->category_name }}
                        </a>
                    </li>
                @endif
            @endforeach
        @endif
        <li><a href="{{ route('about') }}">About Us</a></li>
        <!-- <li><a href="#">Contact</a></li> -->
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

});
</script>