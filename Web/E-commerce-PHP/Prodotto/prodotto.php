<?php
$title = 'Prodotto';

require '../Structure/DbConn.php';
$conf = require '../Structure/db_conf.php';
$db = DbConn::getDB($conf);

require "../Structure/header.php";

// Recupero il prodotto dal database
$codice_prodotto = $_GET['codice'] ?? ''; // Prende il codice prodotto dall'URL

if (empty($codice_prodotto)) {
    echo "<div class='container mt-5 alert alert-danger'>Codice prodotto mancante.</div>";
    require "../Structure/footer.php";
    exit();
}

$query = "SELECT * FROM prodotti WHERE codice = :codice";
$stm = $db->prepare($query);
$stm->bindParam(':codice', $codice_prodotto, PDO::PARAM_STR);

if ($stm->execute()) {
    $prodotto = $stm->fetch(PDO::FETCH_OBJ);
} else {
    echo "<div class='container mt-5 alert alert-danger'>Errore nel recupero del prodotto.</div>";
    require "../Structure/footer.php";
    exit();
}

if (!$prodotto) {
    echo "<div class='container mt-5 alert alert-danger'>Prodotto non trovato.</div>";
    require "../Structure/footer.php";
    exit();
}

// Recupero il materiale associato (ora tramite la chiave esterna in prodotti)
$query_materiali = "SELECT m.tipo, m.lavaggio 
                    FROM materiali m 
                    WHERE m.tipo = :materiale_tipo";
$stm = $db->prepare($query_materiali);
$stm->bindParam(':materiale_tipo', $prodotto->materiale_tipo, PDO::PARAM_STR);
$stm->execute();
$materiali = $stm->fetchAll(PDO::FETCH_OBJ);

// Recupero le taglie disponibili per il prodotto
$query_taglie = "SELECT tipo_taglia FROM prodotti_taglie WHERE codice_prodotto = :codice";
$stm = $db->prepare($query_taglie);
$stm->bindParam(':codice', $codice_prodotto, PDO::PARAM_STR);
$stm->execute();
$taglie = $stm->fetchAll(PDO::FETCH_OBJ);
?>

<div class="container mt-5 bg-body-tertiary rounded-3 px-5 py-4">
    <div class="row">
        <!-- Messaggio di conferma nascosto -->
        <div id="confirmation-message" class="alert alert-success text-center fw-bold d-none">
            Prodotto aggiunto al carrello!
        </div>

        <div class="col-md-6 text-center">
            <!-- Aggiunto id "product-image" per riferimento JS -->
            <img id="product-image" src="<?= $prodotto->immagine ?>" class="img-fluid w-75 rounded-3 products" alt="Immagine Prodotto">
        </div>
        <div class="col-md-6">
            <h1 id="product-title"><?= $prodotto->titolo ?></h1>
            <p id="product-code" class="text-muted">Codice: <?= $prodotto->codice ?></p>
            <h2 id="product-price" class="text-success">€<?= number_format($prodotto->prezzo, 2, ',', '.') ?></h2>
            <p class="lead"><?= $prodotto->descrizione ?></p>

            <!-- Selettore della Taglia -->
            <div class="mt-3">
                <label for="taglia">Taglia:</label>
                <select id="taglia" name="taglia" class="form-control w-50 mb-3">
                    <?php foreach ($taglie as $taglia): ?>
                        <option value="<?= $taglia->tipo_taglia ?>"><?= $taglia->tipo_taglia ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Selettore della Quantità -->
            <div class="mt-4">
                <label for="quantita">Quantità:</label>
                <input type="number" id="quantita" name="quantita" value="1" min="1" class="form-control w-25 mb-3">
                <button id="add-to-cart-button" class="btn btn-dark btn-lg">Aggiungi al Carrello</button>
            </div>

            <!-- Sezione Caratteristiche Tecniche -->
            <div class="mt-5">
                <h3 class="text-info">Caratteristiche Tecniche</h3>
                <table class="table table-bordered">
                    <tbody>
                    <?php if ($materiali): ?>
                        <tr>
                            <td><?= $materiali[0]->tipo ?></td>
                            <td><?= $materiali[0]->lavaggio ? 'Lavabile' : 'Non Lavabile' ?></td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Recensioni -->
    <div class="mt-5">
        <h3 class="text-info">Recensioni Clienti</h3>
        <div id="reviews">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Luca Rossi</h5>
                    <p class="card-text">Prodotto eccellente! La qualità è davvero ottima.</p>
                    <p class="text-muted">★★★★★</p>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Maria Bianchi</h5>
                    <p class="card-text">Buon rapporto qualità-prezzo, spedizione veloce.</p>
                    <p class="text-muted">★★★★☆</p>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Giovanni Verdi</h5>
                    <p class="card-text">Mi aspettavo di più, ma comunque un buon acquisto.</p>
                    <p class="text-muted">★★★☆☆</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require "../Structure/footer.php";
?>

<!-- Include il file JavaScript esterno -->
<script src="prodotto.js"></script>
