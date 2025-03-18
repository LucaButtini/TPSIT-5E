document.addEventListener("DOMContentLoaded", function () {
  const addToCartButton = document.getElementById("add-to-cart-button");

  addToCartButton.addEventListener("click", function () {
    const codiceProdotto = document.getElementById("product-code").textContent.replace("Codice: ", "");
    const tipoTaglia = document.getElementById("taglia").value;
    const quantita = document.getElementById("quantita").value;

    fetch("aggiungi_al_carrello.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: `codice_prodotto=${codiceProdotto}&tipo_taglia=${tipoTaglia}&quantita=${quantita}`,
    })
        .then(response => response.json())
        .then(data => {
          if (data.status === "success") {
            const confirmationMessage = document.getElementById("confirmation-message");
            confirmationMessage.classList.remove("d-none");
            setTimeout(() => confirmationMessage.classList.add("d-none"), 3000);
          } else {
            alert("Errore: " + data.message);
          }
        })
        .catch(error => console.error("Errore nella richiesta:", error));
  });
});
