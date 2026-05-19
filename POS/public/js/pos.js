let cart = [];

/* ================= ADD ================= */

document.querySelectorAll('.add-cart-btn').forEach(btn => {
    btn.addEventListener('click', () => {

        let id = btn.dataset.id;
        let name = btn.dataset.name;
        let price = parseFloat(btn.dataset.price);

        let item = cart.find(i => i.id === id);

        if (item) {
            item.qty++;
        } else {
            cart.push({ id, name, price, qty: 1 });
        }

        renderCart();
    });
});

/* ================= RENDER ================= */

function renderCart() {

    let box = document.getElementById('cartItems');
    let totalBox = document.getElementById('cartTotal');

    box.innerHTML = "";

    let total = 0;

    cart.forEach((item, i) => {

        let sub = item.price * item.qty;
        total += sub;

        box.innerHTML += `
        <div class="cart-item">

            <div class="cart-info">${item.name}</div>

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

    totalBox.innerText = `¥ ${total.toFixed(0)}`;
}

/* ================= QTY ================= */

function inc(i){ cart[i].qty++; renderCart(); }

function dec(i){
    cart[i].qty--;
    if(cart[i].qty <= 0) cart.splice(i,1);
    renderCart();
}

/* ================= REMOVE ================= */

function removeItem(i){
    cart.splice(i,1);
    renderCart();
}

/* ================= SEARCH ================= */

document.getElementById('search').addEventListener('input', e => {

    let val = e.target.value.toLowerCase();

    document.querySelectorAll('.product-card').forEach(c => {
        c.style.display = c.dataset.name.includes(val) ? "block" : "none";
    });
});

/* ================= CATEGORY ================= */

document.querySelectorAll('.category-btn').forEach(btn => {

    btn.addEventListener('click', () => {

        let cat = btn.dataset.category;

        document.querySelectorAll('.product-card').forEach(c => {
            c.style.display = (c.dataset.category === cat) ? "block" : "none";
        });

    });
});

/* ================= THEME ================= */

const toggle = document.getElementById('themeToggle');

function setTheme(t){
    document.body.className = t;
    localStorage.setItem('theme', t);

    if(toggle){
        toggle.innerHTML = t === 'dark'
            ? '<i class="fa fa-sun"></i>'
            : '<i class="fa fa-moon"></i>';
    }
}

setTheme(localStorage.getItem('theme') || 'light');

if(toggle){
    toggle.onclick = () => {
        let t = document.body.classList.contains('dark') ? 'light' : 'dark';
        setTheme(t);
    }
}