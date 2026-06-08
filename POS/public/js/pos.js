let cart = [];
let currentOrderType = "take_away";
let currentPayment = "paid";

/* ================= INIT ================= */
document.addEventListener("DOMContentLoaded", () => {

    initCartEvents();
    initUIEvents();
    initPopupEvents();
    initTheme();

});

/* ================= CART EVENTS ================= */
function initCartEvents() {

    document.querySelectorAll('.add-cart-btn').forEach(btn => {

        btn.addEventListener('click', () => {

            const id = btn.dataset.id;
            const name = btn.dataset.name;
            const price = parseFloat(btn.dataset.price);
            const availableQty = parseInt(btn.dataset.qty) || 0;
            const countable = parseInt(btn.dataset.countable) || 0;

            let item = cart.find(i => i.id === id);

            if (item) {

                if (item.countable === 1 && item.qty >= item.availableQty) {
                    alert("Stock limit reached");
                    return;
                }

                item.qty++;

            } else {

                if (countable === 1 && availableQty <= 0) {
                    alert("Out of stock");
                    return;
                }

                cart.push({
                    id,
                    name,
                    price,
                    qty: 1,
                    availableQty,
                    countable
                });
            }

            renderCart();
        });
    });
}

/* ================= CART RENDER ================= */
function renderCart() {

    const box = document.getElementById("cartItems");
    const totalBox = document.getElementById("cartTotal");
    const countBox = document.getElementById("cartCount");

    if (!box) return;

    let total = 0;
    let qty = 0;

    box.innerHTML = "";

    cart.forEach((item, i) => {

        const sub = item.price * item.qty;

        total += sub;
        qty += item.qty;

        box.innerHTML += `
        <div class="cart-item">

            <div class="cart-info">
                <div class="cart-item-name">${item.name}</div>
            </div>

            <div class="qty-box">
                <button onclick="dec(${i})">-</button>
                <span>${item.qty}</span>
                <button onclick="inc(${i})">+</button>
            </div>

            <div class="cart-price">¥ ${sub.toFixed(0)}</div>

            <button class="remove-btn" onclick="removeItem(${i})">
                <i class="fa fa-trash"></i>
            </button>

        </div>`;
    });

    if (totalBox) totalBox.innerText = total.toFixed(0);
    if (countBox) countBox.innerText = qty;
}

/* ================= QTY ================= */
function inc(i) {

    let item = cart[i];

    if (item.countable === 1 && item.qty >= item.availableQty) {
        alert("Stock limit reached");
        return;
    }

    item.qty++;
    renderCart();
}

function dec(i) {

    cart[i].qty--;

    if (cart[i].qty <= 0) {
        cart.splice(i, 1);
    }

    renderCart();
}

function removeItem(i) {
    cart.splice(i, 1);
    renderCart();
}

/* ================= SEARCH ================= */
function initUIEvents() {

    document.getElementById("search")?.addEventListener("input", e => {

        const val = e.target.value.toLowerCase();

        document.querySelectorAll(".product-card").forEach(card => {
            card.style.display = card.dataset.name.includes(val) ? "block" : "none";
        });
    });

    document.querySelectorAll(".category-btn").forEach(btn => {

        btn.addEventListener("click", () => {

            const cat = btn.dataset.category;

            document.querySelectorAll(".category-btn")
                .forEach(b => b.classList.remove("active-category"));

            btn.classList.add("active-category");

            document.querySelectorAll(".product-card").forEach(card => {

                card.style.display =
                    (cat === "all" || card.dataset.category === cat)
                        ? "block"
                        : "none";
            });
        });
    });
}

/* ================= THEME ================= */
function initTheme() {

    const toggle = document.getElementById("themeToggle");

    function setTheme(t) {

        document.body.className = t;
        localStorage.setItem("theme", t);

        if (toggle) {
            toggle.innerHTML = t === "dark"
                ? '<i class="fa fa-sun"></i>'
                : '<i class="fa fa-moon"></i>';
        }
    }

    setTheme(localStorage.getItem("theme") || "light");

    toggle?.addEventListener("click", () => {

        const t = document.body.classList.contains("dark")
            ? "light"
            : "dark";

        setTheme(t);
    });
}

/* ================= POPUP ================= */
function initPopupEvents() {

    const modal = document.getElementById("checkoutModal");
    const btn = document.querySelector(".checkout-btn");
    const closeBtn = document.querySelector(".close-modal");

    const takeAway = document.getElementById("popupTakeAway");
    const dineIn = document.getElementById("popupDineIn");

    /* OPEN */
    btn?.addEventListener("click", () => {

        if (cart.length === 0) {
            alert("Cart is empty");
            return;
        }

        modal.style.display = "flex";

        renderPopup();
        syncPopupOrderType();
        syncPaymentDefault();
    });

    /* CLOSE */
    closeBtn?.addEventListener("click", () => {
        modal.style.display = "none";
    });

    window.addEventListener("click", (e) => {
        if (e.target === modal) modal.style.display = "none";
    });

    /* ORDER TYPE */
    takeAway?.addEventListener("click", () => {
        currentOrderType = "take_away";
        syncPopupOrderType();
    });

    dineIn?.addEventListener("click", () => {
        currentOrderType = "dine_in";
        syncPopupOrderType();
    });

    /* PAYMENT */
    document.querySelectorAll(".payment-btn").forEach(btn => {

        btn.addEventListener("click", () => {

            document.querySelectorAll(".payment-btn")
                .forEach(b => b.classList.remove("active"));

            btn.classList.add("active");

            currentPayment = btn.dataset.payment;
        });
    });
}

/* ================= POPUP RENDER ================= */
function renderPopup() {

    const box = document.getElementById("popupItemList");
    const totalBox = document.getElementById("popupTotal");

    if (!box || !totalBox) return;

    let total = 0;
    box.innerHTML = "";

    cart.forEach(item => {

        const sub = item.price * item.qty;
        total += sub;

        box.innerHTML += `
        <div class="popup-item">
            <div>
                <strong>${item.name}</strong>
                <small> × ${item.qty}</small>
            </div>
            <div>¥ ${sub.toFixed(0)}</div>
        </div>`;
    });

    totalBox.innerText = total.toFixed(0);
}

/* ================= SYNC ORDER TYPE ================= */
function syncPopupOrderType() {

    const takeAway = document.getElementById("popupTakeAway");
    const dineIn = document.getElementById("popupDineIn");
    const input = document.getElementById("orderType");

    if (!input) return;

    input.value = currentOrderType;

    if (currentOrderType === "dine_in") {
        dineIn?.classList.add("active");
        takeAway?.classList.remove("active");
    } else {
        takeAway?.classList.add("active");
        dineIn?.classList.remove("active");
    }
}

/* ================= PAYMENT DEFAULT ================= */
function syncPaymentDefault() {

    currentPayment = "paid";

    document.querySelectorAll(".payment-btn")
        .forEach(b => b.classList.remove("active"));

    document.querySelector('.payment-btn[data-payment="paid"]')
        ?.classList.add("active");
}