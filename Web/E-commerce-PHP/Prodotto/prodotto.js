document.addEventListener("DOMContentLoaded", () => {
  // Mostra il carrello iniziale se ci sono articoli nel localStorage
  updateCartCount();

  // Aggiungi prodotto al carrello
  document.getElementById('add-to-cart-button').addEventListener('click', function () {
    let taglia = document.getElementById('taglia').value;
    let quantita = document.getElementById('quantita').value;

    if (!taglia) {
      alert("Seleziona una taglia prima di aggiungere al carrello!");
      return;
    }

    // Recupera il prodotto direttamente dal PHP (tutti i dati necessari sono già inclusi)
    let prodotto = {
      codice: document.getElementById("product-code").textContent.trim(),
      titolo: document.getElementById("product-title").textContent.trim(),
      prezzo: document.getElementById("product-price").textContent.trim(),
      immagine: document.getElementById("product-image").src,
      quantita: quantita,
      taglia: taglia
    };

    // Recupera il carrello dal localStorage (o inizializza un array vuoto)
    let carrello = JSON.parse(localStorage.getItem('carrello')) || [];

    // Aggiungi il prodotto al carrello (o aggiorna la quantità se esiste già)
    let prodottoEsistente = carrello.find(item => item.codice === prodotto.codice && item.taglia === prodotto.taglia);
    if (prodottoEsistente) {
      // Se il prodotto esiste già, aggiorna la quantità
      prodottoEsistente.quantita = parseInt(prodottoEsistente.quantita) + parseInt(prodotto.quantita);
    } else {
      // Altrimenti, aggiungilo come nuovo
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

  // Mostra il numero di articoli nel carrello (puoi sostituire 'cart-count' con l'ID di un elemento nella tua pagina)
  let cartCount = document.getElementById('cart-count');
  if (cartCount) {
    cartCount.textContent = numeroArticoli > 0 ? numeroArticoli : ''; // Mostra il numero o nascondi se vuoto
  }
}
