let cart = [];
let currentOrderType = "take_away";
let currentPayment = "paid";

/* ================= INIT ================= */
document.addEventListener("DOMContentLoaded", () => {

    bindCartButtons();
    bindUI();
    bindPopup();
    initTheme();

});

/* ================= CART ================= */
function bindCartButtons() {

    document.querySelectorAll(".add-cart-btn").forEach(btn => {

        btn.addEventListener("click", () => {

            const id = btn.dataset.id;
            const name = btn.dataset.name;
            const price = parseFloat(btn.dataset.price);
            const qty = parseInt(btn.dataset.qty || 0);
            const countable = parseInt(btn.dataset.countable || 0);

            let item = cart.find(i => i.id === id);

            if (item) {

                if (item.countable === 1 && item.qty >= item.availableQty) {
                    alert("Stock limit reached");
                    return;
                }

                item.qty++;

            } else {

                if (countable === 1 && qty <= 0) {
                    alert("Out of stock");
                    return;
                }

                cart.push({
                    id,
                    name,
                    price,
                    qty: 1,
                    availableQty: qty,
                    countable
                });
            }

            renderCart();
        });
    });
}

/* ================= RENDER CART ================= */
function renderCart() {

    const box = document.getElementById("cartItems");
    const totalBox = document.getElementById("cartTotal");
    const countBox = document.getElementById("cartCount");

    if (!box) return;

    box.innerHTML = "";

    let total = 0;
    let count = 0;

    cart.forEach((item, i) => {

        const sub = item.price * item.qty;
        total += sub;
        count += item.qty;

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

    totalBox.innerText = total.toFixed(0);
    countBox.innerText = count;
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
    if (cart[i].qty <= 0) cart.splice(i, 1);
    renderCart();
}

function removeItem(i) {
    cart.splice(i, 1);
    renderCart();
}

/* ================= UI ================= */
function bindUI() {

    document.getElementById("search")?.addEventListener("input", e => {

        let val = e.target.value.toLowerCase();

        document.querySelectorAll(".product-card").forEach(card => {
            card.style.display =
                card.dataset.name.includes(val) ? "block" : "none";
        });
    });

    document.querySelectorAll(".category-btn").forEach(btn => {

        btn.addEventListener("click", () => {

            let cat = btn.dataset.category;

            document.querySelectorAll(".category-btn")
                .forEach(b => b.classList.remove("active-category"));

            btn.classList.add("active-category");

            document.querySelectorAll(".product-card").forEach(card => {
                card.style.display =
                    cat === "all" || card.dataset.category === cat
                        ? "block"
                        : "none";
            });
        });
    });
}

/* ================= POPUP ================= */
function bindPopup() {

    const modal = document.getElementById("checkoutModal");
    const openBtn = document.querySelector(".checkout-btn");
    const closeBtn = document.querySelector(".close-modal");

    const takeBtn = document.getElementById("popupTakeAway");
    const dineBtn = document.getElementById("popupDineIn");

    if (!modal || !openBtn) return;

    /* OPEN */
    openBtn.addEventListener("click", () => {

        if (cart.length === 0) {
            alert("Cart is empty");
            return;
        }

        modal.style.display = "flex";

        renderPopup();
        syncPopup();
        syncPayment();
    });

    /* CLOSE */
    closeBtn?.addEventListener("click", () => {
        modal.style.display = "none";
    });

    window.addEventListener("click", (e) => {
        if (e.target === modal) modal.style.display = "none";
    });

    /* ORDER TYPE TOGGLE */
    takeBtn?.addEventListener("click", () => {
        setOrderType("take_away");
    });

    dineBtn?.addEventListener("click", () => {
        setOrderType("dine_in");
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

/* ================= ORDER TYPE ================= */
function setOrderType(type) {

    currentOrderType = type;

    const takeBtn = document.getElementById("popupTakeAway");
    const dineBtn = document.getElementById("popupDineIn");

    if (type === "dine_in") {
        dineBtn?.classList.add("active");
        takeBtn?.classList.remove("active");
    } else {
        takeBtn?.classList.add("active");
        dineBtn?.classList.remove("active");
    }
}

/* ================= POPUP RENDER ================= */
function renderPopup() {

    const box = document.getElementById("popupItemList");
    const totalBox = document.getElementById("popupTotal");

    if (!box || !totalBox) return;

    box.innerHTML = "";

    let total = 0;

    cart.forEach(item => {

        let sub = item.price * item.qty;
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

/* ================= PAYMENT DEFAULT ================= */
function syncPayment() {

    currentPayment = "paid";

    document.querySelectorAll(".payment-btn")
        .forEach(b => b.classList.remove("active"));

    document.querySelector('.payment-btn[data-payment="paid"]')
        ?.classList.add("active");
}

/* ================= SYNC POPUP ================= */
function syncPopup() {
    setOrderType(currentOrderType);
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

        let t = document.body.classList.contains("dark")
            ? "light"
            : "dark";

        setTheme(t);
    });
}

function setOrderType(type) {

    currentOrderType = type;

    const takeBtn = document.getElementById("popupTakeAway");
    const dineBtn = document.getElementById("popupDineIn");

    const tableGroup = document.getElementById("tableSelectGroup");
    const tableSelect = document.getElementById("tableSelect");

    if (type === "dine_in") {

        dineBtn?.classList.add("active");
        takeBtn?.classList.remove("active");

        // SHOW TABLE
        if (tableGroup) tableGroup.style.display = "block";

    } else {

        takeBtn?.classList.add("active");
        dineBtn?.classList.remove("active");

        // HIDE TABLE
        if (tableGroup) tableGroup.style.display = "none";

        if (tableSelect) tableSelect.value = "";
    }
}

/* ================= CART ================= */
function bindCartButtons() {

    document.querySelectorAll(".product-card").forEach(card => {

        card.addEventListener("click", function(e) {

            const btn = this.querySelector(".add-cart-btn");

            if (!btn) return;

            const id = btn.dataset.id;
            const name = btn.dataset.name;
            const price = parseFloat(btn.dataset.price);
            const qty = parseInt(btn.dataset.qty || 0);
            const countable = parseInt(btn.dataset.countable || 0);

            let item = cart.find(i => i.id === id);

            if (item) {

                if (
                    item.countable === 1 &&
                    item.qty >= item.availableQty
                ) {
                    alert("Stock limit reached");
                    return;
                }

                item.qty++;

            } else {

                if (countable === 1 && qty <= 0) {
                    alert("Out of stock");
                    return;
                }

                cart.push({
                    id,
                    name,
                    price,
                    qty: 1,
                    availableQty: qty,
                    countable
                });
            }

            renderCart();
        });
    });
}