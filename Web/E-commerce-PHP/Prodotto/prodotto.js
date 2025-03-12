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

  document.getElementById("product-title").textContent = product.title;
  document.getElementById("product-code").textContent = product.code;
  document.getElementById("product-price").textContent = product.price;
  document.getElementById("product-description").textContent = product.description;
  document.getElementById("quantity-label").textContent = product.quantityLabel;
  document.getElementById("add-to-cart-button").textContent = product.addToCartButton;
  document.getElementById("description-title").textContent = product.descriptionTitle;
  document.getElementById("detailed-description").textContent = product.detailedDescription;
  document.getElementById("reviews-title").textContent = product.reviewsTitle;

  // Imposta l'immagine
  const imgElement = document.querySelector("img[alt='Immagine Prodotto']");
  if (imgElement) {
    imgElement.src = product.image;
    imgElement.alt = product.title;
  }

  // Sezione recensioni
  const reviewsContainer = document.getElementById("reviews");
  product.reviews.forEach((review) => {
    const reviewElement = document.createElement("div");

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
  const quantity = parseInt(document.getElementById("quantita").value);

  if (quantity <= 0) {
    alert("Seleziona una quantità valida!");
    return;
  }

  let cart = JSON.parse(localStorage.getItem("cart")) || [];
  const existingProduct = cart.find((item) => item.id === product.code);

  if (existingProduct) {
    existingProduct.quantity += quantity;
  } else {
    cart.push({
      id: product.code,
      name: product.title,
      price: parseFloat(product.price.replace("€", "").replace(",", ".")),
      quantity: quantity,
      image: product.image
    });
  }

  localStorage.setItem("cart", JSON.stringify(cart));

  // Mostra il messaggio di conferma
  showConfirmationMessage();
}

// Funzione per mostrare il messaggio di conferma
function showConfirmationMessage() {
  const messageEl = document.getElementById("confirmation-message");
  messageEl.classList.remove("d-none"); // Mostra il messaggio

  // Nasconde il messaggio dopo 2 secondi
  setTimeout(() => {
    messageEl.classList.add("d-none");
  }, 2000);
}


