let cart = [];

/* =========================
   ADD TO CART
========================= */

document.querySelectorAll('.add-cart-btn').forEach(btn => {
    btn.addEventListener('click', () => {

        let id = btn.dataset.id;
        let name = btn.dataset.name;
        let price = parseFloat(btn.dataset.price);

        let existing = cart.find(item => item.id === id);

        if (existing) {
            existing.qty += 1;
        } else {
            cart.push({
                id: id,
                name: name,
                price: price,
                qty: 1
            });
        }

        renderCart();
    });
});

/* =========================
   RENDER CART
========================= */

function renderCart() {

    let cartBox = document.getElementById('cartItems');
    let totalBox = document.getElementById('cartTotal');

    cartBox.innerHTML = "";

    let total = 0;

    cart.forEach((item, index) => {

        let itemTotal = item.price * item.qty;
        total += itemTotal;

        cartBox.innerHTML += `
            <div class="cart-item">

                <div class="cart-info">
                    <b>${item.name}</b>
                </div>

                <div class="qty-box">
                    <button onclick="decreaseQty(${index})">-</button>
                    <span>${item.qty}</span>
                    <button onclick="increaseQty(${index})">+</button>
                </div>

                <div class="cart-price">
                    ¥ ${itemTotal.toFixed(0)}
                </div>

                <button class="remove-btn" onclick="removeItem(${index})">
                    <i class="fa fa-trash"></i>
                </button>

            </div>
        `;
    });

    totalBox.innerText = `¥ ${total.toFixed(0)}`;
}

/* =========================
   QTY CONTROL
========================= */

function increaseQty(index) {
    cart[index].qty++;
    renderCart();
}

function decreaseQty(index) {
    cart[index].qty--;

    if (cart[index].qty <= 0) {
        cart.splice(index, 1);
    }

    renderCart();
}

/* =========================
   REMOVE ITEM
========================= */

function removeItem(index) {
    cart.splice(index, 1);
    renderCart();
}

/* =========================
   SEARCH FILTER
========================= */

document.getElementById('search').addEventListener('keyup', function () {

    let value = this.value.toLowerCase();

    document.querySelectorAll('.product-card').forEach(card => {

        let name = card.dataset.name;

        card.style.display = name.includes(value) ? "block" : "none";
    });
});

/* =========================
   CATEGORY FILTER
========================= */

document.querySelectorAll('.category-btn').forEach(btn => {

    btn.addEventListener('click', () => {

        let category = btn.dataset.category;

        document.querySelectorAll('.product-card').forEach(card => {

            card.style.display =
                (card.dataset.category === category) ? "block" : "none";
        });

    });
});

/* =========================
   THEME TOGGLE
========================= */

const toggleBtn = document.getElementById('themeToggle');

function setTheme(theme) {

    document.body.className = theme;
    localStorage.setItem('pos-theme', theme);

    if (toggleBtn) {
        toggleBtn.innerHTML =
            theme === 'dark'
                ? '<i class="fa fa-sun"></i>'
                : '<i class="fa fa-moon"></i>';
    }
}

// Load theme
let savedTheme = localStorage.getItem('pos-theme') || 'light';
setTheme(savedTheme);

// Toggle click
if (toggleBtn) {
    toggleBtn.addEventListener('click', () => {

        let current = document.body.classList.contains('dark')
            ? 'dark'
            : 'light';

        let next = current === 'dark' ? 'light' : 'dark';

        setTheme(next);
    });
}