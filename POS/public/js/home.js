document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById("orderModal");
    const orderBtns = document.querySelectorAll(".orderBtn");
    const closeBtn = document.querySelector(".close");

    const popupName  = document.getElementById("popupName");
    const popupDesc  = document.getElementById("popupDesc");
    const popupPrice = document.getElementById("popupPrice");
    const popupImage = document.getElementById("popupImage");
    const qtyInput   = document.getElementById("qty");
    let currentItem = null; // this will store the currently selected item

    if (!modal || !closeBtn || !popupName || !popupDesc || !popupPrice || !popupImage || !qtyInput) {
        console.warn('Missing required popup elements. JS skipped.');
        return;
    }

    // OPEN POPUP
    orderBtns.forEach(btn => {
        btn.addEventListener("click", function() {
            currentItem = {
                id: parseInt(this.dataset.id, 10),
                name: this.dataset.name,
                price: parseFloat(this.dataset.price),
                image: this.dataset.image,
                desc: this.dataset.desc
            };

            popupName.textContent  = currentItem.name;
            popupDesc.textContent  = currentItem.desc || 'No description';
            popupPrice.textContent = "Price: " + currentItem.price.toFixed(2);
            popupImage.src         = currentItem.image;
            qtyInput.value = 1;
            modal.style.display = "flex";
        });
    });

    // CLOSE POPUP
    closeBtn.onclick = () => { modal.style.display = "none"; };
    window.onclick = (e) => { if (e.target === modal) { modal.style.display = "none"; } };

    // QUANTITY BUTTONS
    const plusBtn = document.getElementById("plus");
    const minusBtn = document.getElementById("minus");

    plusBtn.onclick = () => { qtyInput.value = parseInt(qtyInput.value, 10) + 1; };
    minusBtn.onclick = () => {
        if (parseInt(qtyInput.value, 10) > 1) {
            qtyInput.value = parseInt(qtyInput.value, 10) - 1;
        }
    };

    // ADD TO CART
    const addCartButton = document.querySelector(".addCartBtn");
    addCartButton.addEventListener("click", function() {
        if (!currentItem || !currentItem.id) {
            alert("Please select an item before adding to cart.");
            return;
        }

        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch(CART_ADD_URL, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-CSRF-TOKEN": token
            },
            body: JSON.stringify({
                id: currentItem.id,
                name: currentItem.name,
                price: currentItem.price,
                image: currentItem.image,
                quantity: parseInt(qtyInput.value, 10)
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const cartCountEl = document.querySelector(".cart-count");
                if (cartCountEl) cartCountEl.innerText = data.count;
                modal.style.display = "none";
                alert("Item added to cart");
            } else {
                alert("Could not add item to cart.");
            }
        })
        .catch(err => {
            console.error("Cart error:", err);
            alert("Error adding item to cart.");
        });
    });
});