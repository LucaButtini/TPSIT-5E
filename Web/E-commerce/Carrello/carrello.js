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
  const cartData = data.cartPage;

  // Navbar
  document.getElementById("navbar-brand").textContent = data.navbar.brand;
  const navbarLinks = document.getElementById("navbar-links");
  data.navbar.links.forEach((link) => {
    const li = document.createElement("li");
    li.className = "nav-item";
    li.innerHTML = `<a class="nav-link ${link.active ? "active" : ""}" href="${link.href}">${link.name}</a>`;
    navbarLinks.appendChild(li);
  });

  // Cart Title
  document.getElementById("cart-title").textContent = cartData.title;

  // Cart Items
  const cartItems = document.getElementById("cart-items");
  cartData.items.forEach((item) => {
    const row = document.createElement("div");
    row.className = "row mb-3";
    row.innerHTML = `
      <div class="col-md-6">
        <h5>${item.title}</h5>
        <p>€${item.price} x ${item.quantity}</p>
      </div>
      <div class="col-md-6 text-end">
        <h5>Totale: €${item.total}</h5>
      </div>
    `;
    cartItems.appendChild(row);
  });

  // Cart Total
  document.getElementById("cart-total").textContent = `Totale Carrello: €${cartData.total}`;

  // Footer
  document.getElementById("footer-author").textContent = data.footer.author;
  document.getElementById("footer-copyright").innerHTML = data.footer.copyright;
}
