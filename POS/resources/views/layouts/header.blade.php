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
                <input type="text" name="query" placeholder="Search Items ..." value="{{ request('query') }}">
            <span class="clear-btn" onclick="document.getElementById('searchInput').value=''">✕</span>
        </form>
        </div>

        <!-- Cart -->
        <div class="cart-icon">
            <a href="{{ route('cart.index') }}"> 🛒
                <span class="cart-count"> {{ session('cart') ? count(session('cart')) : 0 }}</span>
            </a>
        </div>
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
        <li><a href="{{ route('login.post') }}">Login</a></li>
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


document.querySelector(".addCartBtn").addEventListener("click", function(){
    let id = document.querySelector(".orderBtn.active").dataset.id;
    let name = popupName.textContent;
    let price = document.querySelector(".orderBtn.active").dataset.price;
    let image = popupImage.src;
    let qty = qtyInput.value;

    fetch("{{ route('cart.add') }}", {
        method:"POST",
        headers:{
            "Content-Type":"application/json",
            "X-CSRF-TOKEN":"{{ csrf_token() }}"
        },
        body: JSON.stringify({
            id:id,
            name:name,
            price:price,
            image:image,
            quantity:qty
        })
    })
    .then(res => res.json())
    .then(data => {
        if(data.success){
            document.querySelector(".cart-count").innerText = data.count;
            alert("Item added to cart");
            modal.style.display = "none";

        }

    });

});


</script>