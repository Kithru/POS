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
            <input type="text" placeholder="Search Item..." id="searchInput">
            <span class="clear-btn" onclick="document.getElementById('searchInput').value=''">✕</span>
        </div>

        <!-- Cart -->
        <div class="cart-icon">🛒</div>
    </div>
</header>

<!-- Sidebar Menu -->
<nav class="side-menu" id="sideMenu">
    <div class="close-btn" id="closeMenu">
        <i class="fa fa-times"></i>
    </div>
    <ul>
        <li><a href="#">Home</a></li>
        <li><a href="#">Restaurant</a></li>
        <li><a href="#">Grocery</a></li>
        <li><a href="#">About</a></li>
        <li><a href="#">Contact</a></li>
    </ul>
</nav>

<main class="page-content"></main>

<script>
// Sidebar toggle
const menuBtn = document.getElementById("menuBtn");
const sideMenu = document.getElementById("sideMenu");
const closeMenu = document.getElementById("closeMenu");

menuBtn.onclick = () => {
    sideMenu.style.left = "0";
};

closeMenu.onclick = () => {
    sideMenu.style.left = "-260px";
};

// Optional: Clear search input on pressing "✕"
const clearBtn = document.querySelector(".clear-btn");
const searchInput = document.getElementById("searchInput");
clearBtn.onclick = () => searchInput.value = "";
</script>