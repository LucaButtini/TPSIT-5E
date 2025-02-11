document.addEventListener("DOMContentLoaded", () => {
    fetch("carrello.json")
        .then(response => {
            if (!response.ok) throw new Error("Errore nel caricamento del JSON");
            return response.json();
        })
        .then(data => populateCartPage(data.cartPage))
        .catch(error => console.error("Errore:", error));
});

function populateCartPage(cart) {
    document.getElementById("cart-title").textContent = cart.title;
    const cartItemsContainer = document.getElementById("cart-items");
    let total = 0;

    cart.items.forEach(item => {
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
            <p class="card-text">Quantità: ${item.quantity}</p>
          </div>
        </div>
        <div class="col-md-3 text-end pe-4">
          <h5 class="text-success">Totale: €${itemTotal.toFixed(2)}</h5>
        </div>
      </div>
    `;
        cartItemsContainer.appendChild(itemElement);
    });

    document.getElementById("cart-total").textContent = `Totale Carrello: €${total.toFixed(2)}`;
    document.getElementById("checkout-button").textContent = cart.checkoutButton;
}
