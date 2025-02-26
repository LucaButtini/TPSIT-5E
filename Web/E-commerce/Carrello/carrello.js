document.addEventListener("DOMContentLoaded", () => {
    let cart = JSON.parse(localStorage.getItem("cart")) || [];

    if (cart.length === 0 && !localStorage.getItem("cartInitialized")) {
        // Se il carrello è vuoto e non è stato inizializzato, carica i dati dal JSON
        fetch("carrello.json")
            .then(response => response.json())
            .then(data => {
                cart = data.cartPage.items;
                saveCart(cart);
                localStorage.setItem("cartInitialized", "true"); // Segna che il carrello è stato inizializzato
                populateCartPage(cart);
            })
            .catch(error => console.error("Errore nel caricamento del JSON:", error));
    } else {
        populateCartPage(cart);
    }

    // Aggiungi l'evento per il bottone "Applica"
    document.getElementById("apply-discount").addEventListener("click", applyDiscount);
});

function saveCart(cart) {
    localStorage.setItem("cart", JSON.stringify(cart));

    // Se il carrello è completamente vuoto, rimuoviamo il flag di inizializzazione
    if (cart.length === 0) {
        localStorage.removeItem("cartInitialized");
    }
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

    // Mostra il totale del carrello
    document.getElementById("cart-total").textContent = `Totale Carrello: €${total.toFixed(2)}`;
    document.getElementById("checkout-button").textContent = "Procedi al Checkout";
}

// Funzione per aggiornare la quantità
function updateQuantity(index, change) {
    let cart = JSON.parse(localStorage.getItem("cart")) || [];

    if (cart[index]) {
        cart[index].quantity += change;

        // Rimuove il prodotto se la quantità diventa 0 o inferiore
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
        "SCONTO10": 10,  // 10% di sconto
        "PROMO20": 20,   // 20% di sconto
        "VIP30": 30      // 30% di sconto
    };

    let cart = JSON.parse(localStorage.getItem("cart")) || [];
    let total = 0;

    cart.forEach(item => {
        total += item.price * item.quantity;
    });

    // Se il codice di sconto è valido, applicalo
    if (discountCodes[discountCode]) {
        const discount = discountCodes[discountCode];
        const discountAmount = (total * discount) / 100;
        total -= discountAmount;

        // Mostra il messaggio di conferma
        alert(`Sconto applicato! Hai ottenuto uno sconto del ${discount}%`);

    } else {
        // Se il codice non è valido, mostra un messaggio di errore
        alert("Codice sconto non valido!");
    }

    // Mostra il totale aggiornato
    document.getElementById("cart-total").textContent = `Totale Carrello: €${total.toFixed(2)}`;
}
