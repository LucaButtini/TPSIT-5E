// Quando la pagina ha finito di caricare, esegue la funzione
document.addEventListener("DOMContentLoaded", () => {
  // Effettua una richiesta per caricare il file JSON con i dati del prodotto
  fetch("prodotto.json")
      .then((response) => {
        // Se la risposta non è ok, genera un errore con lo status
        if (!response.ok) {
          throw new Error(`Errore nel caricamento del JSON: ${response.statusText}`);
        }
        return response.json(); // Converte la risposta in un oggetto JSON
      })
      .then((data) => {
        // Popola la pagina con i dati del prodotto contenuti nel JSON
        populateProductPage(data.productPage);
      })
      .catch((error) => {
        // Se c'è un errore, lo stampa nella console
        console.error("Errore:", error);
      });
});

// Funzione che riempie la pagina con le informazioni del prodotto
function populateProductPage(product) {
  // Assegna i valori dal JSON agli elementi HTML corrispondenti
  document.getElementById("product-title").textContent = product.title;
  document.getElementById("product-code").textContent = product.code;
  document.getElementById("product-price").textContent = product.price;
  document.getElementById("product-description").textContent = product.description;
  document.getElementById("quantity-label").textContent = product.quantityLabel;
  document.getElementById("add-to-cart-button").textContent = product.addToCartButton;
  document.getElementById("description-title").textContent = product.descriptionTitle;
  document.getElementById("detailed-description").textContent = product.detailedDescription;
  document.getElementById("reviews-title").textContent = product.reviewsTitle;

  // Imposta l'immagine del prodotto se l'elemento esiste
  const imgElement = document.querySelector("img[alt='Immagine Prodotto']");
  if (imgElement) {
    imgElement.src = product.image;
    imgElement.alt = product.title;
  }

  // Sezione recensioni: crea e aggiunge ogni recensione alla pagina
  const reviewsContainer = document.getElementById("reviews");
  product.reviews.forEach((review) => {
    const reviewElement = document.createElement("div");
    // Aggiunge classi Bootstrap per lo stile
    reviewElement.classList.add("mb-3", "p-3", "border", "rounded-3", "bg-light");
    // Struttura HTML della recensione
    reviewElement.innerHTML = `
      <h5>${review.author}</h5>
      <p class="text-warning">${review.rating}</p>
      <p>${review.content}</p>
    `;
    reviewsContainer.appendChild(reviewElement); // Aggiunge la recensione alla pagina
  });

  // Aggiunge un evento al pulsante "Aggiungi al Carrello"
  document.getElementById("add-to-cart-button").addEventListener("click", () => addToCart(product));
}

// Funzione per aggiungere il prodotto al carrello
function addToCart(product) {
  // Ottiene il valore della quantità selezionata
  const quantity = parseInt(document.getElementById("quantita").value);

  // Controlla che la quantità sia valida (maggiore di zero)
  if (quantity <= 0) {
    alert("Seleziona una quantità valida!");
    return;
  }

  // Recupera il carrello dal localStorage o inizializza un array vuoto
  let cart = JSON.parse(localStorage.getItem("cart")) || [];

  // Controlla se il prodotto è già nel carrello
  const existingProduct = cart.find((item) => item.id === product.code);

  if (existingProduct) {
    // Se esiste, aumenta solo la quantità
    existingProduct.quantity += quantity;
  } else {
    // Se non esiste, lo aggiunge come nuovo oggetto nel carrello
    cart.push({
      id: product.code,
      name: product.title,
      price: parseFloat(product.price.replace("€", "").replace(",", ".")), // Converte il prezzo in numero
      quantity: quantity,
      image: product.image
    });
  }

  // Salva il carrello aggiornato nel localStorage
  localStorage.setItem("cart", JSON.stringify(cart));

  // Mostra un avviso di conferma all'utente
  alert("Prodotto aggiunto al carrello!");
}
