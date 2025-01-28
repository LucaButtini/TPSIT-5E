document.addEventListener("DOMContentLoaded", () => {
    fetch("cart.json")
      .then((response) => {
        if (!response.ok) {
          throw new Error(`Errore nel caricamento del JSON: ${response.statusText}`);
        }
        return response.json();
      })
      .then((data) => {
        populateCartPage(data);
      })
      .catch((error) => {
        console.error("Errore:", error);
      });
  });
  
  function populateCartPage(data) {
    const cartData = data.cart;
  
    // Navbar
    document.getElementById("navbar-brand").textContent = data.navbar.brand;
    const navbarLinks = document.getElementById("navbar-links");
    data.navbar.links.forEach((link) => {
      const li = document.createElement("li");
      li.className = "nav-item";
      li.innerHTML = `<a class="nav-link ${link.active ? "active" : ""}" href="${link.href}">${link.name}</a>`;
      navbarLinks.appendChild(li);
    });
  
    // Carrello Titolo
    document.getElementById("cart-title").textContent = cartData.title;
  
    // Aggiungi gli articoli al carrello
    const cartItemsContainer = document.getElementById("cart-items");
    let totalPrice = 0;
    cartData.cartItems.forEach((item) => {
      const itemRow = document.createElement("div");
      itemRow.classList.add("col-md-12", "d-flex", "justify-content-between", "border-bottom", "pb-3", "mb-3");
  
      itemRow.innerHTML = `
        <div class="d-flex align-items-center">
          <img src="${item.image}" class="img-fluid w-25 rounded-3" alt="${item.name}">
          <div class="ms-3">
            <h5>${item.name}</h5>
            <p>€${item.price.toFixed(2)} x ${item.quantity}</p>
          </div>
        </div>
        <div class="d-flex align-items-center">
          <button class="btn btn-sm btn-danger" onclick="removeFromCart('${item.id}')">Rimuovi</button>
        </div>
      `;
  
      cartItemsContainer.appendChild(itemRow);
      totalPrice += item.price * item.quantity;
    });
  
    // Imposta il totale del carrello
    const totalPriceElement = document.getElementById("total-price");
    totalPriceElement.textContent = `€${totalPrice.toFixed(2)}`;
  
    // Footer
    document.getElementById("footer-author").textContent = data.footer.author;
    document.getElementById("footer-copyright").innerHTML = data.footer.copyright;
  
    // Bottone per checkout
    document.getElementById("checkout-button").textContent = cartData.checkoutButton;
  }
  
  // Funzione per rimuovere un prodotto dal carrello (simulata)
  function removeFromCart(productId) {
    console.log(`Prodotto ${productId} rimosso dal carrello`);
    // Logica per rimuovere l'articolo dal carrello
  }
   