document.addEventListener("DOMContentLoaded", () => {
    fetch("home.json")
        .then(response => response.json())
        .then(data => populateHomePage(data))
        .catch(error => console.error("Errore nel caricamento dei dati:", error));
});

function populateHomePage(data) {
    const featuredProductsContainer = document.getElementById("featured-products");

    data.featuredProducts.forEach(product => {
        const productCard = document.createElement("div");
        productCard.className = "col-md-4";
        productCard.innerHTML = `
        <div class="card shadow-sm products">
            <img src="${product.image}" class="card-img-top" alt="${product.name}">
            <div class="card-body">
                <h5 class="card-title">${product.name}</h5>
                <p class="card-text">${product.price}</p>
                <a href="Prodotto/prodotto.php?id=${product.id}" class="btn btn-primary">Vedi Prodotto</a>
            </div>
        </div>`;
        featuredProductsContainer.appendChild(productCard);
    });
}

