<?php
$title = 'Carrello';
require "Structure/header.php";
require 'Structure/DbConn.php';
$conf = require 'Structure/db_conf.php';
$db = DbConn::getDB($conf);

// Se è stata inviata una richiesta di rimozione, la gestiamo subito
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove'])) {
    $codice_da_rimuovere = $_POST['remove'];

    // Recupera il carrello attivo per l'utente
    $query_carrello = "SELECT id FROM carrello WHERE data_creazione = CURDATE() OR utente = :utente";
    $stm = $db->prepare($query_carrello);
    $utente = 'guest'; // Sostituisci con l'username autenticato se disponibile
    $stm->bindParam(':utente', $utente, PDO::PARAM_STR);
    $stm->execute();
    $carrello = $stm->fetch(PDO::FETCH_OBJ);

    if ($carrello) {
        // Rimuove il prodotto dal carrello
        $query_remove = "DELETE FROM ordini WHERE id_carrello = :carrello_id AND prodotto = :codice_prodotto";
        $stm = $db->prepare($query_remove);
        $stm->bindParam(':carrello_id', $carrello->id, PDO::PARAM_INT);
        $stm->bindParam(':codice_prodotto', $codice_da_rimuovere, PDO::PARAM_STR);
        $stm->execute();

        $message = "Prodotto rimosso dal carrello.";
    }
}

// Recupera il carrello attivo per l'utente
$query_carrello = "SELECT id FROM carrello WHERE data_creazione = CURDATE() OR utente = :utente";
$stm = $db->prepare($query_carrello);
$utente = 'guest'; // Sostituisci con l'username autenticato se disponibile
$stm->bindParam(':utente', $utente, PDO::PARAM_STR);
$stm->execute();
$carrello = $stm->fetch(PDO::FETCH_OBJ);

if (!$carrello) {
    echo "<div class='container mt-5 alert alert-warning'>Il tuo carrello è vuoto.</div>";
    require "Structure/footer.php";
    exit();
}

// Recupera i prodotti dal carrello (con quantità)
$query_prodotti = "
    SELECT o.prodotto, o.quantita, p.titolo, p.immagine, p.prezzo
    FROM ordini o
    JOIN prodotti p ON o.prodotto = p.codice
    WHERE o.id_carrello = :carrello_id
";
$stm = $db->prepare($query_prodotti);
$stm->bindParam(':carrello_id', $carrello->id, PDO::PARAM_INT);
$stm->execute();
$prodotti = $stm->fetchAll(PDO::FETCH_OBJ);

// Calcola il totale del carrello
$total = 0;
foreach ($prodotti as $prodotto) {
    $total += $prodotto->prezzo * $prodotto->quantita;
}
?>


    <h1 class="text-center mb-4">Il tuo Carrello</h1>

    <!-- Visualizza messaggio se presente -->
    <?php if (isset($message)): ?>
        <div class="alert alert-info text-center"><?= $message ?></div>
    <?php endif; ?>

    <?php if (empty($prodotti)): ?>
        <div class="alert alert-warning">Il tuo carrello è vuoto.</div>
    <?php else: ?>
        <?php foreach ($prodotti as $prodotto): ?>
            <div class="row mb-3 align-items-center">
                <div class="col-md-2">
                    <img src="<?= htmlspecialchars($prodotto->immagine) ?>" alt="<?= htmlspecialchars($prodotto->titolo) ?>" class="img-fluid">
                </div>
                <div class="col-md-6">
                    <h5><?= htmlspecialchars($prodotto->titolo) ?></h5>
                    <p>Quantità: <?= $prodotto->quantita ?></p>
                </div>
                <div class="col-md-4 text-end">
                    <p>€<?= number_format($prodotto->prezzo * $prodotto->quantita, 2, ',', '.') ?></p>
                    <!-- Form per rimuovere il prodotto dal carrello -->
                    <form method="POST" action="" style="display:inline;">
                        <input type="hidden" name="remove" value="<?= $prodotto->prodotto ?>" />
                        <button type="submit" class="btn btn-danger btn-sm">Rimuovi</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
        <h3 class="text-end">Totale: €<?= number_format($total, 2, ',', '.') ?></h3>
    <?php endif; ?>

    <div class="text-end">
        <a href="Structure/confirm.html" class="btn btn-success mt-3">Procedi al Checkout</a>
    </div>

<?php
require "Structure/footer.php";
?>
