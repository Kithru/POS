let cart = [];

const cartItems = document.getElementById('cartItems');
const cartTotal = document.getElementById('cartTotal');

/* Add to cart */

document.querySelectorAll('.add-cart-btn')
.forEach(button => {

    button.addEventListener('click', () => {

        const id = button.dataset.id;
        const name = button.dataset.name;
        const price = parseFloat(button.dataset.price);

        const existing = cart.find(item => item.id === id);

        if(existing){

            existing.qty++;

        }else{

            cart.push({
                id,
                name,
                price,
                qty:1
            });

        }

        renderCart();

    });

});

/* Render Cart */

function renderCart(){

    cartItems.innerHTML = '';

    let total = 0;

    cart.forEach(item => {

        total += item.price * item.qty;

        cartItems.innerHTML += `

            <div class="cart-item">

                <div>
                    <strong>${item.name}</strong>
                    <br>
                    Qty : ${item.qty}
                </div>

                <div>
                    Rs. ${(item.price * item.qty).toFixed(2)}
                </div>

            </div>

        `;

    });

    cartTotal.innerText = total.toFixed(2);

}

/* Search */

document.getElementById('search')
.addEventListener('keyup', function(){

    const value = this.value.toLowerCase();

    document.querySelectorAll('.product-card')
    .forEach(card => {

        const name = card.dataset.name;

        card.style.display =
            name.includes(value)
            ? 'block'
            : 'none';

    });

});

/* Category Filter */

document.querySelectorAll('.category-btn')
.forEach(button => {

    button.addEventListener('click', () => {

        const category = button.dataset.category;

        document.querySelectorAll('.product-card')
        .forEach(card => {

            card.style.display =
                card.dataset.category === category
                ? 'block'
                : 'none';

        });

    });

});