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
    const cartCountEl = document.getElementById("cartCount"); // header badge

    let currentItemId = null;

    if (!modal || !closeBtn || !popupName || !popupDesc || !popupPrice || !popupImage || !qtyInput || !plusBtn || !minusBtn || !addCartBtn || !cartCountEl) {
        console.warn('Popup elements missing. JS skipped.');
        return;
    }

    // ----- HELPER: Update Cart Count -----
    function updateCartCount(count) {
        cartCountEl.textContent = count;
        cartCountEl.classList.add("updated");
        setTimeout(() => cartCountEl.classList.remove("updated"), 300); // simple pop animation
    }
    window.updateCartCount = updateCartCount;

    // ----- OPEN POPUP -----
    document.addEventListener("click", function(e) {
        const btn = e.target.closest(".orderBtn");
        if (!btn) return;

        currentItemId = parseInt(btn.dataset.id, 10);

        const currentItem = {
            id: currentItemId,
            name: btn.dataset.name,
            price: parseFloat(btn.dataset.price),
            image: btn.dataset.image,
            desc: btn.dataset.desc,
            currency_icon: btn.dataset.currencyIcon || ''
        };

        popupName.textContent = currentItem.name;
        popupDesc.textContent = currentItem.desc || 'No description';
        popupPrice.innerHTML = "¥ " + currentItem.price.toFixed(2);
        popupImage.src = currentItem.image || '/images/no-image.jpg';

        qtyInput.value = 1;
        modal.style.display = "flex";
    });

    // ----- CLOSE POPUP -----
    const closeModal = () => {
        modal.style.display = "none";
        qtyInput.value = 1;
        currentItemId = null;
    };
    closeBtn.addEventListener("click", closeModal);
    window.addEventListener("click", e => { if (e.target === modal) closeModal(); });

    // ----- QUANTITY BUTTONS -----
    plusBtn.addEventListener("click", () => qtyInput.value = parseInt(qtyInput.value, 10) + 1);
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
            body: JSON.stringify({ item_id: currentItemId, quantity })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                updateCartCount(data.count);   // refresh cart badge immediately
                closeModal();

                // Optional: if you have a mini cart list, refresh it
                if (window.refreshCartDropdown) window.refreshCartDropdown();
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


// const CART_ADD_URL = "{{ route('cart.add') }}";

// Banner Auto Slide (3 seconds)
let slides = document.querySelectorAll('.banner-slide');
let currentSlide = 0;

function showSlide(index) {
    slides.forEach((slide, i) => {
        slide.classList.remove('active');
    });
    slides[index].classList.add('active');
}

// Auto change every 5 seconds
setInterval(() => {
    currentSlide++;
    if (currentSlide >= slides.length) {
        currentSlide = 0;
    }
    showSlide(currentSlide);
}, 5000);

function nextSlide() {
    currentSlide++;
    if (currentSlide >= slides.length) {
        currentSlide = 0;
    }
    showSlide(currentSlide);
}

function prevSlide() {
    currentSlide--;
    if (currentSlide < 0) {
        currentSlide = slides.length - 1;
    }
    showSlide(currentSlide);
}

// Category filtering
const categoryButtons = document.querySelectorAll('.category-btn');
const productCards = document.querySelectorAll('.product-card');

categoryButtons.forEach(btn => {
    btn.addEventListener('click', () => {
        // Remove active class from all buttons
        categoryButtons.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        const category = btn.getAttribute('data-category');

        productCards.forEach(card => {
            if (category === 'all' || card.getAttribute('data-category') === category) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });
});

const leftArrow = document.querySelector('.left-arrow');
const rightArrow = document.querySelector('.right-arrow');
const productsContainer = document.getElementById('productsContainer');
const scrollAmount = 220; 

leftArrow.addEventListener('click', () => {
    productsContainer.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
});

rightArrow.addEventListener('click', () => {
    productsContainer.scrollBy({ left: scrollAmount, behavior: 'smooth' });
});

document.addEventListener('DOMContentLoaded', () => {
    if(window.location.hash === '#exploreSection'){
        const explore = document.getElementById('exploreSection');
        if(explore){
            explore.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }
});