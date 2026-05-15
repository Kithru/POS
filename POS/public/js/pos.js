let cart = [];

// Add to cart
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

// Render Cart
function renderCart() {

    let cartBox = document.getElementById('cartItems');
    let totalBox = document.getElementById('cartTotal');

    cartBox.innerHTML = "";

    let total = 0;

    cart.forEach((item, index) => {

        total += item.price * item.qty;

        cartBox.innerHTML += `
            <div class="cart-item">

                <div class="cart-info">
                    <b>${item.name}</b><br>
                    Rs. ${item.price.toFixed(2)}
                </div>

                <div class="qty-box">

                    <button onclick="decreaseQty(${index})">-</button>

                    <span>${item.qty}</span>

                    <button onclick="increaseQty(${index})">+</button>

                </div>

                <div class="cart-price">
                    Rs. ${(item.price * item.qty).toFixed(2)}
                </div>

                <button class="remove-btn" onclick="removeItem(${index})">
                    <i class="fa fa-trash"></i>
                </button>

            </div>
        `;
    });

    totalBox.innerText = total.toFixed(2);
}

// Increase qty
function increaseQty(index) {
    cart[index].qty++;
    renderCart();
}

// Decrease qty
function decreaseQty(index) {
    cart[index].qty--;

    if (cart[index].qty <= 0) {
        cart.splice(index, 1);
    }

    renderCart();
}

// Remove item
function removeItem(index) {
    cart.splice(index, 1);
    renderCart();
}

// Search filter
document.getElementById('search').addEventListener('keyup', function () {

    let value = this.value.toLowerCase();

    document.querySelectorAll('.product-card').forEach(card => {

        let name = card.dataset.name;

        card.style.display = name.includes(value) ? "block" : "none";
    });
});

// Category filter
document.querySelectorAll('.category-btn').forEach(btn => {

    btn.addEventListener('click', () => {

        let category = btn.dataset.category;

        document.querySelectorAll('.product-card').forEach(card => {

            card.style.display =
                (card.dataset.category === category) ? "block" : "none";
        });

    });
});