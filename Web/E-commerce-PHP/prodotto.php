<?php
$title = 'Prodotto';

require 'Structure/DbConn.php';
$conf = require 'Structure/db_conf.php';
$db = DbConn::getDB($conf);

require "Structure/header.php";

// Recupero il prodotto dal database
$codice_prodotto = $_GET['codice'] ?? ''; // Prende il codice prodotto dall'URL

if (empty($codice_prodotto)) {
    echo "<div class='container mt-5 alert alert-danger'>Codice prodotto mancante.</div>";
    require "Structure/footer.php";
    exit();
}

$query = "SELECT * FROM prodotti WHERE codice = :codice";
$stm = $db->prepare($query);
$stm->bindParam(':codice', $codice_prodotto, PDO::PARAM_STR);

if ($stm->execute()) {
    $prodotto = $stm->fetch(PDO::FETCH_OBJ);
} else {
    echo "<div class='container mt-5 alert alert-danger'>Errore nel recupero del prodotto.</div>";
    require "Structure/footer.php";
    exit();
}

if (!$prodotto) {
    echo "<div class='container mt-5 alert alert-danger'>Prodotto non trovato.</div>";
    require "Structure/footer.php";
    exit();
}

// Recupero le taglie disponibili per il prodotto
$query_taglie = "SELECT tipo_taglia FROM prodotti_taglie WHERE codice_prodotto = :codice";
$stm = $db->prepare($query_taglie);
$stm->bindParam(':codice', $codice_prodotto, PDO::PARAM_STR);
$stm->execute();
$taglie = $stm->fetchAll(PDO::FETCH_OBJ);

// Gestione aggiunta al carrello
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recupero i dati del prodotto e della quantità selezionata
    $codice_prodotto = $_POST['codice'];
    $taglia = $_POST['taglia'];
    $quantita = $_POST['quantita'];

    // Step 1: Verifica se c'è già un carrello esistente
    $query_carrello = "SELECT id FROM carrello WHERE data_creazione > NOW() - INTERVAL 1 HOUR";
    $stm = $db->prepare($query_carrello);
    $stm->execute();
    $carrello = $stm->fetch(PDO::FETCH_OBJ);

    // Step 2: Se non c'è un carrello attivo, creiamo un nuovo carrello
    if (!$carrello) {
        $query_crea_carrello = "INSERT INTO carrello (data_creazione) VALUES (NOW())";
        $db->exec($query_crea_carrello);
        $carrello_id = $db->lastInsertId();
    } else {
        $carrello_id = $carrello->id;
    }

    // Step 3: Aggiungi il prodotto selezionato al carrello
    $query_aggiungi_prodotto = "INSERT INTO carrello_prodotti (carrello_id, codice_prodotto, taglia, quantita) 
                                VALUES (:carrello_id, :codice_prodotto, :taglia, :quantita)";
    $stm = $db->prepare($query_aggiungi_prodotto);
    $stm->bindParam(':carrello_id', $carrello_id, PDO::PARAM_INT);
    $stm->bindParam(':codice_prodotto', $codice_prodotto, PDO::PARAM_STR);
    $stm->bindParam(':taglia', $taglia, PDO::PARAM_STR);
    $stm->bindParam(':quantita', $quantita, PDO::PARAM_INT);

    if ($stm->execute()) {
        echo "<div class='container mt-5 alert alert-success text-center fw-bold'>Prodotto aggiunto al carrello!</div>";
    } else {
        echo "<div class='container mt-5 alert alert-danger text-center'>Errore nell'aggiungere il prodotto al carrello.</div>";
    }
}

?>

<div class="container mt-5 bg-body-tertiary rounded-3 px-5 py-4">
    <div class="row">
        <div class="col-md-6 text-center">
            <img id="product-image" src="<?= $prodotto->immagine ?>" class="img-fluid w-75 rounded-3 products" alt="Immagine Prodotto">
        </div>
        <div class="col-md-6">
            <h1 id="product-title"><?= $prodotto->titolo ?></h1>
            <p id="product-code" class="text-muted">Codice: <?= $prodotto->codice ?></p>
            <h2 id="product-price" class="text-success">€<?= number_format($prodotto->prezzo, 2, ',', '.') ?></h2>
            <p class="lead"><?= $prodotto->descrizione ?></p>

            <!-- Form per l'aggiunta al carrello -->
            <form method="POST" action="prodotto.php?codice=<?= $prodotto->codice ?>" class="mt-3">
                <!-- Selettore della Taglia -->
                <label for="taglia">Taglia:</label>
                <select id="taglia" name="taglia" class="form-control w-50 mb-3">
                    <?php foreach ($taglie as $taglia): ?>
                        <option value="<?= $taglia->tipo_taglia ?>"><?= $taglia->tipo_taglia ?></option>
                    <?php endforeach; ?>
                </select>

                <!-- Selettore della Quantità -->
                <label for="quantita">Quantità:</label>
                <input type="number" id="quantita" name="quantita" value="1" min="1" class="form-control w-25 mb-3">

                <button type="submit" class="btn btn-dark btn-lg">Aggiungi al Carrello</button>
                <input type="hidden" name="codice" value="<?= $prodotto->codice ?>" />
            </form>
        </div>
    </div>
    <!-- Sezione Recensioni -->
    <div class="container mt-5">
        <h2>Recensioni</h2>

        <div class="list-group">
            <div class="list-group-item">
                <h5 class="mb-1">Mario Rossi</h5>
                <small class="text-muted">⭐⭐⭐⭐⭐</small>
                <p class="mb-1">Ottimo prodotto! Qualità eccellente e consegna veloce. Lo consiglio a tutti!</p>
            </div>

            <div class="list-group-item">
                <h5 class="mb-1">Laura Bianchi</h5>
                <small class="text-muted">⭐⭐⭐⭐</small>
                <p class="mb-1">Buon prodotto, ma la confezione era leggermente danneggiata all’arrivo.</p>
            </div>

            <div class="list-group-item">
                <h5 class="mb-1">Giovanni Verdi</h5>
                <small class="text-muted">⭐⭐⭐⭐⭐</small>
                <p class="mb-1">Perfetto! Esattamente come descritto, sono molto soddisfatto dell'acquisto.</p>
            </div>
        </div>
    </div>

</div>

<?php
require "Structure/footer.php";
?>
