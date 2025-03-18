<?php
$title = 'Carrello';
require "Structure/header.php";
require 'Structure/DbConn.php';
$conf = require 'Structure/db_conf.php';
$db = DbConn::getDB($conf);

// Recupera il carrello attivo: per il database attuale, usiamo la data odierna
$query_carrello = "SELECT id FROM carrello WHERE data_creazione = CURDATE()";
$stm = $db->prepare($query_carrello);
$stm->execute();
$carrello = $stm->fetch(PDO::FETCH_OBJ);

if (!$carrello) {
    echo "<div class='container mt-5 alert alert-warning'>Il tuo carrello è vuoto.</div>";
    require "Structure/footer.php";
    exit();
}

// Recupera i prodotti inseriti nel carrello
$query_prodotti = "
    SELECT cp.codice_prodotto, cp.taglia, cp.quantita, p.titolo, p.immagine, p.prezzo
    FROM carrello_prodotti cp
    JOIN prodotti p ON cp.codice_prodotto = p.codice
    WHERE cp.carrello_id = :carrello_id
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
                    <!-- Assicurati che il percorso dell'immagine sia coerente con quello usato in prodotto.php -->
                    <img src="<?= htmlspecialchars($prodotto->immagine) ?>" alt="<?= htmlspecialchars($prodotto->titolo) ?>" class="img-fluid">
                </div>
                <div class="col-md-6">
                    <h5><?= htmlspecialchars($prodotto->titolo) ?> <small>(Taglia: <?= htmlspecialchars($prodotto->taglia) ?>)</small></h5>
                    <p>Quantità: <?= $prodotto->quantita ?></p>
                </div>
                <div class="col-md-4 text-end">
                    <p>€<?= number_format($prodotto->prezzo * $prodotto->quantita, 2, ',', '.') ?></p>
                </div>
            </div>
        <?php endforeach; ?>
        <h3 class="text-end">Totale: €<?= number_format($total, 2, ',', '.') ?></h3>
    <?php endif; ?>

    <!-- Codice sconto (eventuale) e link al checkout -->
    <div class="d-flex justify-content-between align-items-center mt-4">
        <div class="w-50">
            <input type="text" id="discount-code" class="form-control" placeholder="Codice Sconto (es: ITIS10)">
        </div>
        <button id="apply-discount" class="btn btn-primary ms-2">Applica</button>
    </div>

    <div class="text-end">
        <a href="Structure/confirm.html" class="btn btn-success mt-3">Procedi al Checkout</a>
    </div>
</div>

<?php
require "Structure/footer.php";
?>
