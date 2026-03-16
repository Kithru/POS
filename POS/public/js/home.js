document.addEventListener('DOMContentLoaded', function () {

    // ----- POPUP ELEMENTS -----
    const modal = document.getElementById("orderModal");
    const orderBtns = document.querySelectorAll(".orderBtn");
    const closeBtn = document.querySelector(".close");

    const popupName  = document.getElementById("popupName");
    const popupDesc  = document.getElementById("popupDesc");
    const popupPrice = document.getElementById("popupPrice");
    const popupImage = document.getElementById("popupImage");
    const qtyInput   = document.getElementById("qty");
    const plusBtn    = document.getElementById("plus");
    const minusBtn   = document.getElementById("minus");
    const addCartBtn = document.querySelector(".addCartBtn");

    let currentItemId = null;

    if (!modal || !closeBtn || !popupName || !popupDesc || !popupPrice || !popupImage || !qtyInput || !plusBtn || !minusBtn || !addCartBtn) {
        console.warn('Popup elements missing. JS skipped.');
        return;
    }

    // ----- OPEN POPUP -----
    orderBtns.forEach(btn => {
        btn.addEventListener("click", function() {

            currentItemId = parseInt(this.dataset.id, 10); 
            const currentItem = {
                id: currentItemId,
                name: this.dataset.name,
                price: parseFloat(this.dataset.price),
                image: this.dataset.image,
                desc: this.dataset.desc,
                currency_icon: this.dataset.currencyIcon || ''  // dataset.camelCase works
            };
            popupName.textContent  = currentItem.name;
            popupDesc.textContent  = currentItem.desc || 'No description';
            popupPrice.textContent = currentItem.currency_icon + " " + currentItem.price.toFixed(2);
            popupImage.src         = currentItem.image;
            qtyInput.value = 1;
            modal.style.display = "flex";
        });
    });

    // ----- CLOSE POPUP -----
    const closeModal = () => {
        modal.style.display = "none";
        qtyInput.value = 1;
        currentItemId = null;
    };

    closeBtn.addEventListener("click", closeModal);
    window.addEventListener("click", (e) => {
        if (e.target === modal) closeModal();
    });

    // ----- QUANTITY BUTTONS -----
    plusBtn.addEventListener("click", () => {
        qtyInput.value = parseInt(qtyInput.value, 10) + 1;
    });

    minusBtn.addEventListener("click", () => {
        let qty = parseInt(qtyInput.value, 10);
        if (qty > 1) qtyInput.value = qty - 1;
    });

    // ----- ADD TO CART -----
    addCartBtn.addEventListener("click", function() {

        if (!currentItemId) {
            alert("Please select an item.");
            return;
        }

        const quantity = parseInt(qtyInput.value, 10);
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch(CART_ADD_URL, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-CSRF-TOKEN": token
            },
            body: JSON.stringify({
                item_id: currentItemId,
                quantity: quantity
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // Update cart count in header if exists
                const cartCountEl = document.querySelector(".cart-count");
                if (cartCountEl) cartCountEl.innerText = data.count;

                // Close popup
                closeModal();
            } else {
                alert(data.message || "Could not add item to cart.");
            }
        })
        .catch(err => {
            console.error("Cart error:", err);
            alert("Error adding item to cart.");
        });

    });

});