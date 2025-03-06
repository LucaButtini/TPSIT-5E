// Attende che la pagina sia completamente caricata prima di eseguire il codice
document.addEventListener("DOMContentLoaded", () => {
    // Effettua una richiesta per ottenere i dati dal file JSON "archivio.json"
    fetch("archivio.json")
        .then(response => {
            // Controlla se la risposta è valida
            if (!response.ok) throw new Error("Errore nel caricamento del JSON");
            return response.json(); // Converte la risposta in JSON
        })
        .then(data => populateArchivePage(data.archivePage)) // Popola la pagina con i dati ottenuti
        .catch(error => console.error("Errore:", error)); // Gestisce eventuali errori
});

// Funzione per popolare la pagina dell'archivio con i prodotti
function populateArchivePage(archive) {
    // Imposta il titolo della pagina dell'archivio
    document.getElementById("archive-title").textContent = archive.title;

    const productList = document.getElementById("product-list"); // Seleziona il contenitore dei prodotti

    // Itera su tutti i prodotti presenti nell'archivio
    archive.products.forEach(product => {
        const col = document.createElement("div"); // Crea un div per ogni prodotto
        col.className = "col-md-4 mb-4"; // Aggiunge classi Bootstrap per la griglia

        // Determina la pagina giusta per il prodotto in base al suo tipo
        const productPage = product.type === "single2" ? "single2.php" : "prodotto.php";

        // Crea il contenuto della card del prodotto
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

        // Aggiunge il prodotto alla lista dei prodotti visibili nella pagina
        productList.appendChild(col);
    });
}
