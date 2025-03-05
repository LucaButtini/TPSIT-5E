// Attende il caricamento della pagina prima di eseguire il codice
document.addEventListener("DOMContentLoaded", () => {
    // Recupera il carrello dal localStorage o inizializza un array vuoto se non esiste
    let cart = JSON.parse(localStorage.getItem("cart")) || [];

    // Controlla se è la prima volta che viene caricato il carrello, per evitare di sovrascriverlo
    if (!localStorage.getItem("firstLoadDone")) {
        // Carica il carrello di default da un file JSON
        fetch("carrello.json")
            .then(response => response.json()) // Converte la risposta in JSON
            .then(data => {
                cart = data.cartPage.items; // Assegna i dati del JSON al carrello
                saveCart(cart); // Salva il carrello nel localStorage
                localStorage.setItem("firstLoadDone", "true"); // Imposta il flag per evitare il reset futuro
                populateCartPage(cart); // Mostra i prodotti nel carrello
            })
            .catch(error => console.error("Errore nel caricamento del JSON:", error));
    } else {
        // Se il carrello esiste già, lo mostra senza ricaricare i dati dal JSON
        populateCartPage(cart);
    }

    // Aggiunge gli event listener per il codice sconto e il pagamento
    document.getElementById("apply-discount").addEventListener("click", applyDiscount);
    document.getElementById("checkout-button").addEventListener("click", processPayment);
});

// Funzione per salvare il carrello nel localStorage
function saveCart(cart) {
    localStorage.setItem("cart", JSON.stringify(cart));
}

// Funzione per popolare la pagina del carrello con i prodotti salvati
function populateCartPage(cart) {
    const cartItemsContainer = document.getElementById("cart-items");
    cartItemsContainer.innerHTML = ""; // Pulisce il contenuto precedente
    let total = 0;

    cart.forEach((item, index) => {
        const itemTotal = item.price * item.quantity; // Calcola il totale per il prodotto
        total += itemTotal; // Aggiunge il totale al prezzo complessivo del carrello

        // Crea l'elemento HTML per il prodotto nel carrello
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
        cartItemsContainer.appendChild(itemElement); // Aggiunge il prodotto al carrello visibile
    });

    // Aggiorna il totale del carrello nella pagina
    document.getElementById("cart-total").textContent = `Totale Carrello: €${total.toFixed(2)}`;
    document.getElementById("checkout-button").textContent = "Procedi al Checkout";
}

// Funzione per aggiornare la quantità di un prodotto nel carrello
function updateQuantity(index, change) {
    let cart = JSON.parse(localStorage.getItem("cart")) || [];

    if (cart[index]) {
        cart[index].quantity += change; // Modifica la quantità del prodotto

        // Se la quantità diventa 0 o meno, rimuove il prodotto dal carrello
        if (cart[index].quantity <= 0) {
            cart.splice(index, 1);
        }

        saveCart(cart); // Salva il carrello aggiornato nel localStorage
        populateCartPage(cart); // Aggiorna la visualizzazione del carrello
    }
}

// Funzione per rimuovere un prodotto dal carrello
function removeFromCart(index) {
    let cart = JSON.parse(localStorage.getItem("cart")) || [];
    cart.splice(index, 1); // Rimuove il prodotto selezionato dal carrello
    saveCart(cart); // Salva il carrello aggiornato
    populateCartPage(cart); // Aggiorna la visualizzazione
}

// Funzione per applicare un codice sconto
function applyDiscount() {
    const discountCode = document.getElementById("discount-code").value.trim().toUpperCase(); // Recupera e normalizza il codice sconto
    const discountCodes = {
        "ITIS10": 10, // 10% di sconto
        "ITIS20": 20, // 20% di sconto
        "ITIS30": 30  // 30% di sconto
    };

    let cart = JSON.parse(localStorage.getItem("cart")) || [];
    let total = 0;

    // Calcola il totale del carrello
    cart.forEach(item => {
        total += item.price * item.quantity;
    });

    // Se il codice sconto è valido, calcola il nuovo totale
    if (discountCodes[discountCode]) {
        const discount = discountCodes[discountCode]; // Percentuale di sconto
        const discountAmount = (total * discount) / 100; // Calcola lo sconto
        total -= discountAmount; // Applica lo sconto al totale

        alert(`Sconto applicato! Hai ottenuto uno sconto del ${discount}%`);
    } else {
        alert("Codice sconto non valido!"); // Se il codice non è valido, mostra un messaggio di errore
    }

    // Aggiorna il totale del carrello nella pagina
    document.getElementById("cart-total").textContent = `Totale Carrello: €${total.toFixed(2)}`;
}

// Funzione per simulare il pagamento
function processPayment() {
    if (confirm("Vuoi procedere con il pagamento?")) {
        alert("Pagamento completato con successo!"); // Messaggio di conferma
        localStorage.removeItem("cart"); // Svuota il carrello
        window.location.reload(); // Ricarica la pagina per aggiornare lo stato del carrello
    }
}
