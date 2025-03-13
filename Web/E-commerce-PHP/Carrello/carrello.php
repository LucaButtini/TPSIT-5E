<?php
$title = 'Carrello';
require "../Structure/header.php";
require '../Structure/DbConn.php';
$conf = require '../Structure/db_conf.php';
$db = DbConn::getDB($conf);

// Recuperiamo il carrello attivo dell'utente
$query_carrello = "SELECT id FROM carrello WHERE data_creazione > NOW() - INTERVAL 1 HOUR";
$stm = $db->prepare($query_carrello);
$stm->execute();
$carrello = $stm->fetch(PDO::FETCH_OBJ);

if (!$carrello) {
    echo "<div class='container mt-5 alert alert-warning'>Il tuo carrello è vuoto.</div>";
    require "../Structure/footer.php";
    exit();
}

// Recuperiamo i prodotti nel carrello
$query_prodotti = "
    SELECT cp.id, p.codice, p.titolo, p.immagine, cp.taglia, cp.quantita, p.prezzo
    FROM carrello_prodotti cp
    JOIN prodotti p ON cp.codice_prodotto = p.codice
    WHERE cp.carrello_id = :carrello_id
";
$stm = $db->prepare($query_prodotti);
$stm->bindParam(':carrello_id', $carrello->id, PDO::PARAM_INT);
$stm->execute();
$prodotti = $stm->fetchAll(PDO::FETCH_OBJ);

// Calcolo il totale del carrello
$total = 0;
foreach ($prodotti as $prodotto) {
    $total += $prodotto->prezzo * $prodotto->quantita;
}

?>

<div class="container mt-5 bg-body-tertiary rounded-3 px-5 py-4">
    <h1 class="text-center mb-4" id="cart-title"><strong>Il tuo Carrello</strong></h1>
    <div id="cart-items" class="mb-4">
        <?php foreach ($prodotti as $prodotto): ?>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="d-flex align-items-center">
                    <!-- Immagine del prodotto -->
                    <img src="../images/<?= htmlspecialchars($prodotto->immagine) ?>" alt="<?= htmlspecialchars($prodotto->titolo) ?>" class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover; margin-right: 20px;">
                    <div>
                        <h5><?= htmlspecialchars($prodotto->titolo) ?> (<?= htmlspecialchars($prodotto->taglia) ?>)</h5>
                        <p>Quantità: <?= $prodotto->quantita ?></p>
                    </div>
                </div>
                <div>
                    <p class="text-end">€<?= number_format($prodotto->prezzo * $prodotto->quantita, 2, ',', '.') ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Codice sconto -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <input type="text" id="discount-code" class="form-control w-50" placeholder="Codice Sconto (es: ITIS10, ecc...)">
        <button id="apply-discount" class="btn btn-primary ms-2">Applica</button>
    </div>

    <h3 id="cart-total" class="text-end text-success">Totale: €<?= number_format($total, 2, ',', '.') ?></h3>

    <div class="text-end">
        <a href="../Structure/confirm.html" class="btn btn-success mt-3">Procedi al Checkout</a>
    </div>
</div>

<?php
require "../Structure/footer.php";
?>
