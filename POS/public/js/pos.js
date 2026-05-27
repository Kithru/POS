let cart = [];

/* ================= ADD TO CART ================= */

document.querySelectorAll('.add-cart-btn').forEach(btn => {

    btn.addEventListener('click', () => {

        let id = btn.dataset.id;
        let name = btn.dataset.name;
        let price = parseFloat(btn.dataset.price);

        let availableQty = parseInt(btn.dataset.qty) || 0;
        let countable = parseInt(btn.dataset.countable) || 0;

        let item = cart.find(i => i.id === id);

        // EXISTING ITEM
        if (item) {

            if (item.countable === 1 && item.qty >= item.availableQty) {
                alert('Available items are over.');
                return;
            }

            item.qty++;

        } else {

            if (countable === 1 && availableQty <= 0) {
                alert('Item out of stock.');
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


/* ================= RENDER CART ================= */

function renderCart() {

    let box = document.getElementById('cartItems');
    let totalBox = document.getElementById('cartTotal');
    let cartCount = document.getElementById('cartCount');

    box.innerHTML = "";

    let total = 0;
    let totalQty = 0;

    cart.forEach((item, i) => {

        let sub = item.price * item.qty;

        total += sub;
        totalQty += item.qty;

        box.innerHTML += `
        <div class="cart-item">

            <div class="cart-info">
                <div class="cart-item-name">${item.name}</div>
            </div>

            <!-- QTY -->
            <div class="qty-box">

                <button onclick="dec(${i})">-</button>

                <span class="qty-text">${item.qty}</span>

                <button onclick="inc(${i})">+</button>

            </div>

            <!-- AMOUNT (EDITABLE LABEL) -->
            <div class="cart-price">

                <span class="currency">¥</span>

                <span class="amount-label"
                      contenteditable="true"
                      onblur="updateAmount(${i}, this.innerText)">
                    ${sub.toFixed(0)}
                </span>

            </div>

            <button class="remove-btn" onclick="removeItem(${i})">
                <i class="fa fa-trash"></i>
            </button>

        </div>`;
    });

    totalBox.innerText = total.toFixed(0);
    cartCount.innerText = totalQty;
}


/* ================= INCREASE QTY ================= */

function inc(i) {

    let item = cart[i];

    if (item.countable === 1) {

        if (item.qty >= item.availableQty) {
            alert(item.name + ' available items are over.');
            return;
        }
    }
    item.qty++;

    renderCart();
}


/* ================= DECREASE QTY ================= */

function dec(i) {

    cart[i].qty--;

    if (cart[i].qty <= 0) {
        cart.splice(i, 1);
    }

    renderCart();
}


/* ================= REMOVE ITEM ================= */

function removeItem(i) {

    cart.splice(i, 1);

    renderCart();
}


/* ================= UPDATE AMOUNT ================= */

function updateAmount(i, value) {

    // clean input
    value = value.replace(/[^0-9.]/g, '');

    let amount = parseFloat(value);

    if (isNaN(amount) || amount < 0) {
        amount = 0;
    }

    if (cart[i].qty <= 0) return;

    cart[i].price = amount / cart[i].qty;

    renderCart();
}


/* ================= SEARCH ================= */

document.getElementById('search').addEventListener('input', e => {

    let val = e.target.value.toLowerCase();

    document.querySelectorAll('.product-card').forEach(c => {

        c.style.display =
            c.dataset.name.includes(val)
                ? "block"
                : "none";
    });
});


/* ================= CATEGORY FILTER ================= */

document.querySelectorAll('.category-btn').forEach(btn => {

    btn.addEventListener('click', () => {

        let cat = btn.dataset.category;

        document.querySelectorAll('.category-btn')
            .forEach(b => b.classList.remove('active-category'));

        btn.classList.add('active-category');

        document.querySelectorAll('.product-card').forEach(c => {

            if (cat === 'all') {
                c.style.display = "block";
            } else {
                c.style.display =
                    (c.dataset.category === cat)
                        ? "block"
                        : "none";
            }
        });
    });
});


/* ================= THEME ================= */

const toggle = document.getElementById('themeToggle');

function setTheme(t) {

    document.body.className = t;

    localStorage.setItem('theme', t);

    if (toggle) {
        toggle.innerHTML =
            t === 'dark'
                ? '<i class="fa fa-sun"></i>'
                : '<i class="fa fa-moon"></i>';
    }
}

setTheme(localStorage.getItem('theme') || 'light');

if (toggle) {

    toggle.onclick = () => {

        let t = document.body.classList.contains('dark')
            ? 'light'
            : 'dark';

        setTheme(t);
    };
}


/* ================= ORDER TYPE ================= */

const dineInBtn = document.getElementById('dineInBtn');
const takeAwayBtn = document.getElementById('takeAwayBtn');
const tableSection = document.getElementById('tableSection');
const orderTypeInput = document.getElementById('orderType');

function setOrderType(type) {

    if (type === 'dine_in') {

        dineInBtn.classList.add('active');
        takeAwayBtn.classList.remove('active');

        tableSection.style.display = 'block';

        orderTypeInput.value = 'dine_in';

    } else {

        takeAwayBtn.classList.add('active');
        dineInBtn.classList.remove('active');

        tableSection.style.display = 'none';

        orderTypeInput.value = 'take_away';

        document.getElementById('tableSelect').value = "";
    }
}

dineInBtn.addEventListener('click', () => setOrderType('dine_in'));
takeAwayBtn.addEventListener('click', () => setOrderType('take_away'));