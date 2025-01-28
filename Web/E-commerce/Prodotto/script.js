document.addEventListener("DOMContentLoaded", () => {
    fetch("content.json")
      .then((response) => {
        if (!response.ok) {
          throw new Error(`Errore nel caricamento del JSON: ${response.statusText}`);
        }
        return response.json();
      })
      .then((data) => {
        populatePage(data);
      })
      .catch((error) => {
        console.error("Errore:", error);
      });
  });
  
  function populatePage(data) {
    const productData = data.productPage;
  
    // Navbar
    document.getElementById("navbar-brand").textContent = data.navbar.brand;
    const navbarLinks = document.getElementById("navbar-links");
    data.navbar.links.forEach((link) => {
      const li = document.createElement("li");
      li.className = "nav-item";
      li.innerHTML = `<a class="nav-link ${link.active ? "active" : ""}" href="${link.href}">${link.name}</a>`;
      navbarLinks.appendChild(li);
    });
  
    // Product Details
    document.getElementById("product-title").textContent = productData.title;
    document.getElementById("product-code").textContent = productData.code;
    document.getElementById("product-price").textContent = productData.price;
    document.getElementById("product-description").textContent = productData.description;
    document.getElementById("quantity-label").textContent = productData.quantityLabel;
    document.getElementById("add-to-cart-button").textContent = productData.addToCartButton;
  
    // Detailed Description and Titles
    document.getElementById("description-title").textContent = productData.descriptionTitle;
    document.getElementById("detailed-description").textContent = productData.detailedDescription;
  
    // Reviews Section
    document.getElementById("reviews-title").textContent = productData.reviewsTitle;
    const reviewsContainer = document.getElementById("reviews");
    reviewsContainer.innerHTML = ""; // Clear existing content if any
    productData.reviews.forEach((review) => {
      const reviewDiv = document.createElement("div");
      reviewDiv.className = "border p-3 mb-3";
      reviewDiv.innerHTML = `
        <p><strong>${review.author}</strong> <span class="text-warning">${review.rating}</span></p>
        <p>${review.content}</p>
      `;
      reviewsContainer.appendChild(reviewDiv);
    });
  
    // Footer
    document.getElementById("footer-author").textContent = data.footer.author;
    document.getElementById("footer-copyright").innerHTML = data.footer.copyright;
  }
  