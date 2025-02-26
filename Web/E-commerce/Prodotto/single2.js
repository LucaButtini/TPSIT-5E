document.addEventListener("DOMContentLoaded", () => {
    fetch("single2.json")
        .then(response => response.json())
        .then(data => {
            populateProductPage(data.productPage);
        })
        .catch(error => console.error("Errore:", error));
});

function populateProductPage(product) {
    document.getElementById("product-title").textContent = product.title;
    document.getElementById("product-code").textContent = product.code;
    document.getElementById("product-price").textContent = product.price;
    document.getElementById("product-description").textContent = product.description;
    document.getElementById("quantity-label").textContent = product.quantityLabel;
    document.getElementById("add-to-cart-button").textContent = product.addToCartButton;
    document.getElementById("reviews-title").textContent = product.reviewsTitle;

    const imgElement = document.querySelector("img[alt='Immagine Prodotto']");
    imgElement.src = product.image;
    imgElement.alt = product.title;

    // Carica caratteristiche tecniche
    const techDetailsContainer = document.getElementById("technical-details");
    for (const key in product.technicalDetails) {
        const row = document.createElement("tr");
        row.innerHTML = `<th>${key}</th><td>${product.technicalDetails[key]}</td>`;
        techDetailsContainer.appendChild(row);
    }

    // Carica le recensioni
    const reviewsContainer = document.getElementById("reviews");
    product.reviews.forEach(review => {
        const reviewElement = document.createElement("div");
        reviewElement.classList.add("mb-3", "p-3", "border", "rounded-3", "bg-light");
        reviewElement.innerHTML = `
            <h5>${review.author}</h5>
            <p class="text-warning">${review.rating}</p>
            <p>${review.content}</p>
        `;
        reviewsContainer.appendChild(reviewElement);
    });

    // Evento per aggiungere il prodotto al carrello con varianti
    document.getElementById("add-to-cart-button").addEventListener("click", () => addToCart(product));
}

function addToCart(product) {
    const quantity = parseInt(document.getElementById("quantita").value);
    const taglia = document.getElementById("taglia").value;
    const colore = document.getElementById("colore").value;

    if (quantity <= 0) {
        alert("Seleziona una quantità valida!");
        return;
    }

    let cart = JSON.parse(localStorage.getItem("cart")) || [];

    // Verifica se il prodotto con la stessa variante è già nel carrello
    const existingProduct = cart.find(item => item.id === product.code && item.taglia === taglia && item.colore === colore);

    if (existingProduct) {
        existingProduct.quantity += quantity;
    } else {
        cart.push({
            id: product.code,
            name: product.title,
            price: parseFloat(product.price.replace("€", "").replace(",", ".")), // Converte in numero
            quantity: quantity,
            image: product.image,
            taglia: taglia,
            colore: colore
        });
    }

    localStorage.setItem("cart", JSON.stringify(cart));
    alert(`Prodotto aggiunto al carrello!\nTaglia: ${taglia}, Colore: ${colore}`);
}
