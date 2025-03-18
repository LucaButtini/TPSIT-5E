<?php
$title = 'Carrello';
require "Structure/header.php";
require 'Structure/DbConn.php';
$conf = require 'Structure/db_conf.php';
$db = DbConn::getDB($conf);

// Recupera il carrello attivo per l'utente
$query_carrello = "SELECT id FROM carrello WHERE data_creazione = CURDATE() OR utente = :utente";
$stm = $db->prepare($query_carrello);
$utente = 'guest'; // Sostituisci con il nome utente autenticato, se presente
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

<div class="container mt-5 bg-body-tertiary rounded-3 px-5 py-4">
    <h1 class="text-center mb-4">Il tuo Carrello</h1>

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
                </div>
            </div>
        <?php endforeach; ?>
        <h3 class="text-end">Totale: €<?= number_format($total, 2, ',', '.') ?></h3>
    <?php endif; ?>

    <div class="text-end">
        <a href="Structure/confirm.html" class="btn btn-success mt-3">Procedi al Checkout</a>
    </div>
</div>

<?php
require "Structure/footer.php";
?>
