<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<header class="header">

    <!-- TOP BAR -->
    <div class="header-top">
        <!-- LEFT: LOCATION -->
        <div class="header-left-navi">
            <a href="{{ route('home') }}">
                <img src="{{ asset('images/logo.png') }}" alt="Company Logo" class="logo-navi">
            </a>
        </div>

        <div class="nav-wrapper-headernavi">
            <nav class="nav-menu">
                <div class="nav-dropdown" id="categoryDropdown">
                    <span class="nav-link dropdown-toggle">
                        Categories <i class="fas fa-chevron-down"></i>
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
                
                <div class="nav-dropdown" id="aboutDropdown">
                    <span class="nav-link dropdown-toggle {{ request()->routeIs('about') ? 'active' : '' }}">
                        About <i class="fas fa-chevron-down"></i>
                    </span>
                    <div class="dropdown-menu" id="aboutMenu">
                        <a href="{{ route('about') }}">About Us</a>
                        <a href="{{ route('about') }}#contactus">Contact Us</a>
                        <a href="{{ route('about') }}#B">Delivery Information</a>
                        <a href="{{ route('about') }}#C">Terms & Conditions</a>
                    </div>
                </div>

                <a href="{{ route('order.track') }}" class="nav-link {{ request()->routeIs('order.track') ? 'active' : '' }}">Track Order</a>
            </nav>
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

    const dropdown = document.getElementById("categoryDropdown");
    const menu = document.getElementById("dropdownMenu");

    const aboutDropdown = document.getElementById("aboutDropdown");
    const aboutMenu = document.getElementById("aboutMenu");

    function setupDropdown(dropdown, menu) {
        if (dropdown && menu) {

            dropdown.addEventListener("click", function(e){
                e.stopPropagation();

                menu.classList.toggle("show");
                dropdown.classList.toggle("open");
            });

            menu.addEventListener("click", function(e){
                e.stopPropagation();
            });
        }
    }
    setupDropdown(categoryDropdown, dropdownMenu);
    setupDropdown(aboutDropdown, aboutMenu);

    document.addEventListener("click", function () {

        if(dropdownMenu){
            dropdownMenu.classList.remove("show");
            categoryDropdown.classList.remove("open");
        }

        if(aboutMenu){
            aboutMenu.classList.remove("show");
            aboutDropdown.classList.remove("open");
        }

    });

    window.updateCartCount = function(count) {
        const el = document.getElementById("cartCount");
        if (el) el.textContent = count;
    };

});
</script>