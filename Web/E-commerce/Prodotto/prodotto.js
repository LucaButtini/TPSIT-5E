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

  // Aggiungi l'immagine del prodotto
  const imgElement = document.querySelector("img[alt='Immagine Prodotto']");
  if (imgElement) {
    imgElement.src = product.image;
    imgElement.alt = product.title;
  }

  // Aggiungi le recensioni
  const reviewsContainer = document.getElementById("reviews");
  product.reviews.forEach((review) => {
    const reviewElement = document.createElement("div");
    reviewElement.classList.add("mb-3", "p-3", "border", "rounded-3", "bg-light");
    reviewElement.innerHTML = `
      <h5>${review.author}</h5>
      <p>${review.rating}</p>
      <p>${review.content}</p>
    `;
    reviewsContainer.appendChild(reviewElement);
  });
}
