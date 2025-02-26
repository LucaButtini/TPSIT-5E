document.addEventListener("DOMContentLoaded", () => {
  fetch("prodotto.json")
      .then((response) => {
        if (!response.ok) {
          throw new Error(`Errore nel caricamento del JSON: ${response.statusText}`);
        }
        return response.json();
      })
      .then((data) => {
        populateProductPage(data.productPage);
      })
      .catch((error) => {
        console.error("Errore:", error);
      });
});

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

  // immagine
  const imgElement = document.querySelector("img[alt='Immagine Prodotto']");
  if (imgElement) {
    imgElement.src = product.image;
    imgElement.alt = product.title;
  }

  // recensioni
  const reviewsContainer = document.getElementById("reviews");
  product.reviews.forEach((review) => {
    const reviewElement = document.createElement("div");
    reviewElement.classList.add("mb-3", "p-3", "border", "rounded-3", "bg-light");
    reviewElement.innerHTML = `
      <h5>${review.author}</h5>
      <p class="text-warning">${review.rating}</p>
      <p>${review.content}</p>
    `;
    reviewsContainer.appendChild(reviewElement);
  });

  document.getElementById("add-to-cart-button").addEventListener("click", () => addToCart(product));
}

function addToCart(product) {
  const quantity = parseInt(document.getElementById("quantita").value);
  if (quantity <= 0) {
    alert("Seleziona una quantità valida!");
    return;
  }

  let cart = JSON.parse(localStorage.getItem("cart")) || [];

  // Controlla se il prodotto è già nel carrello
  const existingProduct = cart.find((item) => item.id === product.code);

  if (existingProduct) {
    existingProduct.quantity += quantity; // Aggiorna la quantità
  } else {
    cart.push({
      id: product.code,
      name: product.title,
      price: parseFloat(product.price.replace("€", "").replace(",", ".")), // Converte in numero
      quantity: quantity,
      image: product.image
    });
  }

  localStorage.setItem("cart", JSON.stringify(cart));
  alert("Prodotto aggiunto al carrello!");
}
