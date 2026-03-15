const modal = document.getElementById("orderModal");
const orderBtns = document.querySelectorAll(".orderBtn");
const closeBtn = document.querySelector(".close");

const popupName  = document.getElementById("popupName");
const popupDesc  = document.getElementById("popupDesc");
const popupPrice = document.getElementById("popupPrice");
const popupImage = document.getElementById("popupImage");
const qtyInput = document.getElementById("qty");
let currentItem = {};


// OPEN POPUP
orderBtns.forEach(btn => {
    btn.addEventListener("click", function(){
        currentItem = {
            id: this.dataset.id,
            name: this.dataset.name,
            price: this.dataset.price,
            image: this.dataset.image
        };

        popupName.textContent  = this.dataset.name;
        popupDesc.textContent  = this.dataset.desc;
        popupPrice.textContent = "Price : " + this.dataset.price;
        popupImage.src         = this.dataset.image;
        qtyInput.value = 1;
        modal.style.display = "flex";
    });
});

// CLOSE POPUP
closeBtn.onclick = () => {
    modal.style.display = "none";
};

window.onclick = (e) => {
    if(e.target === modal){
        modal.style.display = "none";
    }
};

// QUANTITY BUTTONS
document.getElementById("plus").onclick = () => {
    qtyInput.value = parseInt(qtyInput.value) + 1;
};

document.getElementById("minus").onclick = () => {
    if(qtyInput.value > 1){
        qtyInput.value = parseInt(qtyInput.value) - 1;
    }
};


// ADD TO CART
document.querySelector(".addCartBtn").addEventListener("click", function(){
    fetch("{{ route('cart.add') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },

        body: JSON.stringify({
            id: currentItem.id,
            name: currentItem.name,
            price: currentItem.price,
            image: currentItem.image,
            quantity: qtyInput.value
        })

    })
    .then(res => res.json())
    .then(data => {
        if(data.success){
            document.querySelector(".cart-count").innerText = data.count;
            modal.style.display = "none";
            alert("Item added to cart");

        }

    });

});


orderBtns.forEach(btn => {

    btn.addEventListener("click", function(){
        document.querySelectorAll(".orderBtn").forEach(b => b.classList.remove("active"));
        this.classList.add("active");
        popupName.textContent = this.dataset.name;
        popupDesc.textContent = this.dataset.desc;
        popupPrice.textContent = "Price : " + this.dataset.price;
        popupImage.src = this.dataset.image;
        modal.style.display = "flex";
    });
});