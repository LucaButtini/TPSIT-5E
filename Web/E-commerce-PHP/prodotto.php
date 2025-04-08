<?php

$title = 'Prodotto';

//  connessione al database
require 'Structure/DbConn.php';


$conf = require 'Structure/db_conf.php';


$db = DbConn::getDB($conf);


require "Structure/header.php";

// codice prodotto con get
$codice_prodotto = $_GET['codice'] ?? '';

// se il codice prodotto non è presente, mostra un messaggio di errore e termina lo script
if (empty($codice_prodotto)) {
    echo "<div class='container mt-5 alert alert-danger'>Codice prodotto mancante.</div>";
    require "Structure/footer.php";
    exit();
}

// query per prodotto
$query = "SELECT * FROM prodotti WHERE codice = :codice";
$stm = $db->prepare($query);
$stm->bindParam(':codice', $codice_prodotto);
if ($stm->execute()) {
    $prodotto = $stm->fetch();
} else {
    //messaggio di errore recupero prodotto
    echo "<div class='container mt-5 alert alert-danger'>Errore nel recupero del prodotto.</div>";
    require "Structure/footer.php";
    exit();
}

// messaggio di errore se  il prodotto non viene trovato
if (!$prodotto) {
    echo "<div class='container mt-5 alert alert-danger'>Prodotto non trovato.</div>";
    require "Structure/footer.php";
    exit();
}

// query per le taglie
$query_taglie = "SELECT tipo_taglia FROM prodotti_taglie WHERE codice_prodotto = :codice";
$stm = $db->prepare($query_taglie);
$stm->bindParam(':codice', $codice_prodotto);
$stm->execute();
$taglie = $stm->fetchAll();

// gestione  carrello
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recupera i dati dal form
    $codice_prodotto = $_POST['codice'];
    $quantita = (int) $_POST['quantita'];

    // verifica se esiste già un carrello attivo per oggi
    $query_carrello = "SELECT id FROM carrello WHERE data_creazione = CURDATE()";
    $stm = $db->prepare($query_carrello);
    $stm->execute();
    $carrello = $stm->fetch();

    if (!$carrello) {
        // Se non esiste un carrello per oggi, lo crea
        $query_crea_carrello = "INSERT INTO carrello (data_creazione) VALUES (CURDATE())";
        $db->exec($query_crea_carrello);
        $carrello_id = $db->lastInsertId();
    } else {
        // Usa l'ID del carrello esistente
        $carrello_id = $carrello->id;
    }

    // guarda se il prodotto è già presente nel carrello
    $query_check = "SELECT quantita FROM ordini WHERE id_carrello = :carrello_id AND prodotto = :codice_prodotto";
    $stm = $db->prepare($query_check);
    $stm->bindParam(':carrello_id', $carrello_id, PDO::PARAM_INT);
    $stm->bindParam(':codice_prodotto', $codice_prodotto, PDO::PARAM_STR);
    $stm->execute();
    $existing = $stm->fetch(PDO::FETCH_OBJ);

    if ($existing) {
        // se il prodotto è già nel carrello, aggiorna la quantità
        $new_quantita = $existing->quantita + $quantita;
        $query_update = "UPDATE ordini SET quantita = :new_quantita WHERE id_carrello = :carrello_id AND prodotto = :codice_prodotto";
        $stm = $db->prepare($query_update);
        $stm->bindParam(':new_quantita', $new_quantita, PDO::PARAM_INT);
        $stm->bindParam(':carrello_id', $carrello_id, PDO::PARAM_INT);
        $stm->bindParam(':codice_prodotto', $codice_prodotto, PDO::PARAM_STR);
        $stm->execute();
    } else {
        // se prodotto non è nel carrello, lo aggiunge
        $query_insert = "INSERT INTO ordini (id_carrello, prodotto, quantita) VALUES (:carrello_id, :codice_prodotto, :quantita)";
        $stm = $db->prepare($query_insert);
        $stm->bindParam(':carrello_id', $carrello_id, PDO::PARAM_INT);
        $stm->bindParam(':codice_prodotto', $codice_prodotto, PDO::PARAM_STR);
        $stm->bindParam(':quantita', $quantita, PDO::PARAM_INT);
        $stm->execute();
    }

    //  messaggio di conferma o errore
    if ($stm->rowCount() > 0) {
        echo "<div class='container mt-5 alert alert-success text-center fw-bold'>Prodotto aggiunto al carrello!</div>";
    } else {
        echo "<div class='container mt-5 alert alert-danger text-center'>Errore nell'aggiungere il prodotto al carrello.</div>";
    }
}
?>

<!-- Mostra i dettagli del prodotto -->
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

            <!-- Form per aggiungere il prodotto al carrello -->
            <form method="POST" action="prodotto.php?codice=<?= $prodotto->codice ?>" class="mt-3">
                <label for="taglia">Taglia:</label>
                <select id="taglia" name="taglia" class="form-control w-50 mb-3">
                    <?php foreach ($taglie as $taglia){ ?>
                        <option value="<?= $taglia->tipo_taglia ?>"><?= $taglia->tipo_taglia ?></option>
                    <?php } ?>
                </select>

                <!-- Input per selezionare la quantità -->
                <label for="quantita">Quantità:</label>
                <input type="number" id="quantita" name="quantita" value="1" min="1" class="form-control w-25 mb-3">

                <button type="submit" class="btn btn-dark btn-lg">Aggiungi al Carrello</button>
                <input type="hidden" name="codice" value="<?= $prodotto->codice ?>" />
            </form>
        </div>
    </div>

    <!-- Sezione recensioni -->
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
        </div>
    </div>
</div>

<?php

require "Structure/footer.php";
?>
