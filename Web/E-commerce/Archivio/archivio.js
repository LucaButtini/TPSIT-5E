document.addEventListener("DOMContentLoaded", () => {
    fetch("archivio.json")
        .then(response => {
            if (!response.ok) throw new Error("Errore nel caricamento del JSON");
            return response.json();
        })
        .then(data => populateArchivePage(data.archivePage))
        .catch(error => console.error("Errore:", error));
});

function populateArchivePage(archive) {
    document.getElementById("archive-title").textContent = archive.title;

    const productList = document.getElementById("product-list");
    archive.products.forEach(product => {
        const col = document.createElement("div");
        col.className = "col-md-4 mb-4";

        // Determina la pagina giusta per il prodotto
        const productPage = product.type === "single2" ? "single2.php" : "prodotto.php";

        col.innerHTML = `
            <div class="card h-100 products">
                <img src="${product.image}" class="card-img-top" alt="${product.name}">
                <div class="card-body">
                    <h5 class="card-title"><strong>${product.name}</strong></h5>
                    <p class="card-text">${product.description}</p>
                    <h6 class="text-success">${product.price}</h6>
                    <a href="../Prodotto/${productPage}?id=${product.id}" class="btn btn-dark w-100">Visualizza Dettagli</a>
                </div>
            </div>
        `;
        productList.appendChild(col);
    });
}
