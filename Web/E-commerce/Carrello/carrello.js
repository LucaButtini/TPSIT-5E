document.addEventListener("DOMContentLoaded", () => {
    let cart = JSON.parse(localStorage.getItem("cart")) || [];

    // Usa "firstLoadDone" invece di "cartInitialized" per evitare di ricaricare i prodotti di default dopo la prima volta
    if (!localStorage.getItem("firstLoadDone")) {
        fetch("carrello.json")
            .then(response => response.json())
            .then(data => {
                cart = data.cartPage.items;
                saveCart(cart);
                localStorage.setItem("firstLoadDone", "true"); // Imposta il flag per evitare il reset
                populateCartPage(cart);
            })
            .catch(error => console.error("Errore nel caricamento del JSON:", error));
    } else {
        populateCartPage(cart);
    }

    document.getElementById("apply-discount").addEventListener("click", applyDiscount);
    document.getElementById("checkout-button").addEventListener("click", processPayment);
});

function saveCart(cart) {
    localStorage.setItem("cart", JSON.stringify(cart));
}

function populateCartPage(cart) {
    const cartItemsContainer = document.getElementById("cart-items");
    cartItemsContainer.innerHTML = "";
    let total = 0;

    cart.forEach((item, index) => {
        const itemTotal = item.price * item.quantity;
        total += itemTotal;

        const itemElement = document.createElement("div");
        itemElement.className = "card mb-3 shadow-sm";
        itemElement.innerHTML = `
            <div class="row g-0 align-items-center">
                <div class="col-md-3 text-center">
                    <img src="${item.image}" class="img-fluid rounded-start" alt="${item.name}">
                </div>
                <div class="col-md-6">
                    <div class="card-body">
                        <h5 class="card-title">${item.name}</h5>
                        <p class="card-text">Prezzo: €${item.price.toFixed(2)}</p>
                        <div class="d-flex align-items-center">
                            <button class="btn btn-outline-secondary btn-sm me-2" onclick="updateQuantity(${index}, -1)">-</button>
                            <span class="fw-bold mx-2" id="quantity-${index}">${item.quantity}</span>
                            <button class="btn btn-outline-secondary btn-sm ms-2" onclick="updateQuantity(${index}, 1)">+</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 text-end pe-4">
                    <h5 class="text-success">Totale: €${itemTotal.toFixed(2)}</h5>
                    <button class="btn btn-danger btn-sm mt-2" onclick="removeFromCart(${index})">Rimuovi</button>
                </div>
            </div>
        `;
        cartItemsContainer.appendChild(itemElement);
    });

    document.getElementById("cart-total").textContent = `Totale Carrello: €${total.toFixed(2)}`;
    document.getElementById("checkout-button").textContent = "Procedi al Checkout";
}

// Funzione per aggiornare la quantità
function updateQuantity(index, change) {
    let cart = JSON.parse(localStorage.getItem("cart")) || [];

    if (cart[index]) {
        cart[index].quantity += change;

        if (cart[index].quantity <= 0) {
            cart.splice(index, 1);
        }

        saveCart(cart);
        populateCartPage(cart);
    }
}

// Funzione per rimuovere un prodotto dal carrello
function removeFromCart(index) {
    let cart = JSON.parse(localStorage.getItem("cart")) || [];
    cart.splice(index, 1);
    saveCart(cart);
    populateCartPage(cart);
}

// Funzione per applicare il codice sconto
function applyDiscount() {
    const discountCode = document.getElementById("discount-code").value.trim().toUpperCase();
    const discountCodes = {
        "ITIS10": 10,
        "ITIS20": 20,
        "ITIS30": 30
    };

    let cart = JSON.parse(localStorage.getItem("cart")) || [];
    let total = 0;

    cart.forEach(item => {
        total += item.price * item.quantity;
    });

    if (discountCodes[discountCode]) {
        const discount = discountCodes[discountCode];
        const discountAmount = (total * discount) / 100;
        total -= discountAmount;

        alert(`Sconto applicato! Hai ottenuto uno sconto del ${discount}%`);
    } else {
        alert("Codice sconto non valido!");
    }

    document.getElementById("cart-total").textContent = `Totale Carrello: €${total.toFixed(2)}`;
}

// Funzione per il pagamento
function processPayment() {
    if (confirm("Vuoi procedere con il pagamento?")) {
        alert("Pagamento completato con successo!");
        localStorage.removeItem("cart"); // Svuota il carrello
        window.location.reload(); // Ricarica la pagina
    }
}
