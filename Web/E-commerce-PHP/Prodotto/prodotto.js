document.addEventListener("DOMContentLoaded", () => {
  // Aggiorna il conteggio del carrello (se presente, per esempio in un elemento con id "cart-count")
  updateCartCount();

  // Aggiungi il listener per il bottone "Aggiungi al Carrello"
  document.getElementById('add-to-cart-button').addEventListener('click', function () {
    let taglia = document.getElementById('taglia').value;
    let quantita = document.getElementById('quantita').value;

    if (!taglia) {
      alert("Seleziona una taglia prima di aggiungere al carrello!");
      return;
    }

    // Recupera il prodotto dal DOM
    let prodotto = {
      // Rimuove la parte "Codice: " dal testo
      codice: document.getElementById("product-code").textContent.replace('Codice: ', '').trim(),
      titolo: document.getElementById("product-title").textContent.trim(),
      prezzo: document.getElementById("product-price").textContent.trim(),
      immagine: document.getElementById("product-image").src,
      quantita: quantita,
      taglia: taglia
    };

    // Recupera il carrello dal localStorage (o inizializza un array vuoto)
    let carrello = JSON.parse(localStorage.getItem('carrello')) || [];

    // Aggiunge il prodotto al carrello o aggiorna la quantità se esiste già
    let prodottoEsistente = carrello.find(item => item.codice === prodotto.codice && item.taglia === prodotto.taglia);
    if (prodottoEsistente) {
      prodottoEsistente.quantita = parseInt(prodottoEsistente.quantita) + parseInt(prodotto.quantita);
    } else {
      carrello.push(prodotto);
    }

    // Salva il carrello aggiornato nel localStorage
    localStorage.setItem('carrello', JSON.stringify(carrello));

    // Mostra il messaggio di conferma sopra l'immagine
    document.getElementById('confirmation-message').classList.remove('d-none');

    // Nasconde il messaggio dopo 2 secondi
    setTimeout(() => {
      document.getElementById('confirmation-message').classList.add('d-none');
    }, 2000);

    // Aggiorna il conteggio del carrello nella UI
    updateCartCount();
  });
});

// Funzione per aggiornare il conteggio degli articoli nel carrello
function updateCartCount() {
  let carrello = JSON.parse(localStorage.getItem('carrello')) || [];
  let numeroArticoli = carrello.reduce((total, item) => total + parseInt(item.quantita), 0);

  let cartCount = document.getElementById('cart-count');
  if (cartCount) {
    cartCount.textContent = numeroArticoli > 0 ? numeroArticoli : '';
  }
}
