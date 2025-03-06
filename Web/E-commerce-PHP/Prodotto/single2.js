// Attende il caricamento completo della pagina prima di eseguire il codice
document.addEventListener("DOMContentLoaded", () => {
    // Effettua una richiesta per caricare i dati dal file JSON "single2.json"
    fetch("single2.json")
        .then(response => {
            // Verifica che la risposta sia valida, altrimenti genera un errore
            if (!response.ok) throw new Error("Errore nel caricamento del JSON");
            return response.json(); // Converte la risposta in formato JSON
        })
        .then(data => populateProductPage(data.productPage)) // Popola la pagina con i dati del prodotto
        .catch(error => console.error("Errore:", error));
});

// Funzione per popolare la pagina del prodotto con i dati del JSON
function populateProductPage(product) {

    document.getElementById("product-title").textContent = product.title;
    document.getElementById("product-code").textContent = product.code;
    document.getElementById("product-price").textContent = product.price;
    document.getElementById("product-description").textContent = product.description;
    document.getElementById("quantity-label").textContent = product.quantityLabel;
    document.getElementById("add-to-cart-button").textContent = product.addToCartButton;
    document.getElementById("reviews-title").textContent = product.reviewsTitle;

    // immagine
    const imgElement = document.querySelector("img[alt='Immagine Prodotto']");
    imgElement.src = product.image;
    imgElement.alt = product.title;

    // Popola la tabella caratteristiche tecniche
    const techDetailsContainer = document.getElementById("technical-details");
    // Svuota eventuali dati precedenti
    techDetailsContainer.innerHTML = "";
    for (const key in product.technicalDetails) {
        //riga tabella
        const row = document.createElement("tr");
        row.innerHTML = `<th>${key}</th><td>${product.technicalDetails[key]}</td>`;
        techDetailsContainer.appendChild(row); // Aggiunge la riga alla tabella
    }

    // Popola la sezione delle recensioni
    const reviewsContainer = document.getElementById("reviews");
    reviewsContainer.innerHTML = ""; // Svuota eventuali dati precedenti
    product.reviews.forEach(review => {
        const reviewElement = document.createElement("div");
        reviewElement.classList.add("mb-3", "p-3", "border", "rounded-3", "bg-light");
        reviewElement.innerHTML = `
            <h5>${review.author}</h5>
            <p class="text-warning">${review.rating}</p>
            <p>${review.content}</p>
        `;
        reviewsContainer.appendChild(reviewElement); // Aggiunge la recensione alla sezione
    });

    // Aggiunge un evento al pulsante Aggiungi al carrello
    document.getElementById("add-to-cart-button").addEventListener("click", () => addToCart(product));
}

// Funzione per aggiungere un prodotto al carrello
function addToCart(product) {
    // Ottiene la quantità selezionata dall'utente
    const quantity = parseInt(document.getElementById("quantita").value);

    // Verifica che la quantità sia valida
    if (quantity <= 0) {
        alert("Seleziona una quantità valida!");
        return;
    }

    // Recupera il carrello dal localStorage o inizializza un array vuoto
    //QUA DA ERRORE SULLA CONSOLE NEL BROWSER
    let cart = JSON.parse(localStorage.getItem("cart")) || [];

    // Controlla se il prodotto è già nel carrello
    const existingProduct = cart.find(item => item.id === product.code);
    if (existingProduct) {
        existingProduct.quantity += quantity; // Se esiste, aggiorna la quantità
    } else {
        // Se non esiste, aggiunge il prodotto al carrello
        cart.push({
            id: product.code,
            name: product.title,
            price: parseFloat(product.price.replace("€", "").replace(",", ".")), // serve a Convertire il prezzo in numero
            quantity: quantity,
            image: product.image
        });
    }

    // Salva il carrello aggiornato nel localStorage
    localStorage.setItem("cart", JSON.stringify(cart));
    alert(`Prodotto aggiunto al carrello!`);
}
