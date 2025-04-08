<?php
 // connessione al database

$title = 'Carrello';
require "Structure/header.php";
require 'Structure/DbConn.php';
$conf = require 'Structure/db_conf.php';
$db = DbConn::getDB($conf);

// Verifica se l'utente è autenticato
$utente = $_SESSION['utente'] ?? 'guest'; // Se non è loggato, viene trattato come 'guest'

// Se è stata inviata una richiesta di rimozione del prodotto
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove'])) {
    $codice_da_rimuovere = $_POST['remove'];

    // Recupera il carrello attivo per l'utente
    $query_carrello = "SELECT id FROM carrello WHERE utente = :utente";
    $stm = $db->prepare($query_carrello);
    $stm->bindParam(':utente', $utente);
    $stm->execute();
    $carrello = $stm->fetch();

    if ($carrello) {
        // Rimuove il prodotto dal carrello
        $query_remove = "DELETE FROM ordini WHERE id_carrello = :carrello_id AND prodotto = :codice_prodotto";
        $stm = $db->prepare($query_remove);
        $stm->bindParam(':carrello_id', $carrello->id);
        $stm->bindParam(':codice_prodotto', $codice_da_rimuovere);
        $stm->execute();

        $message = "Prodotto rimosso dal carrello.";
    }
}

// Recupera il carrello attivo per l'utente
$query_carrello = "SELECT id FROM carrello WHERE utente = :utente";
$stm = $db->prepare($query_carrello);
$stm->bindParam(':utente', $utente);
$stm->execute();
$carrello = $stm->fetch();

// Se il carrello non esiste, lo crea
if (!$carrello) {
    $query_crea_carrello = "INSERT INTO carrello (utente, data_creazione) VALUES (:utente, NOW())";
    $stm = $db->prepare($query_crea_carrello);
    $stm->bindParam(':utente', $utente);
    $stm->execute();
    $carrello_id = $db->lastInsertId();
} else {
    $carrello_id = $carrello->id;
}

// Recupera i prodotti nel carrello
$query_prodotti = "
    SELECT o.prodotto, o.quantita, p.titolo, p.immagine, p.prezzo
    FROM ordini o
    JOIN prodotti p ON o.prodotto = p.codice
    WHERE o.id_carrello = :carrello_id
";
$stm = $db->prepare($query_prodotti);
$stm->bindParam(':carrello_id', $carrello_id);
$stm->execute();
$prodotti = $stm->fetchAll();

//  totale del carrello
$total = 0;
foreach ($prodotti as $prodotto) {
    $total += $prodotto->prezzo * $prodotto->quantita;
}
?>

<div class="container mt-5">
    <h1 class="text-center mb-4">Il tuo Carrello</h1>

    <?php if (isset($message)){ //messaggio prodotto rimosso ?>
        <div class="alert alert-info text-center"><?= $message ?></div>
    <?php } ?>

    <?php if (empty($prodotti)){ // messaggio carrello vuoto ?>
        <div class="alert alert-warning text-center">Il tuo carrello è vuoto.</div>
    <?php }else{ ?>
        <?php foreach ($prodotti as $prodotto){ //visualizza prodotti nel carrello?>
            <div class="row mb-3 align-items-center">
                <div class="col-md-2">
                    <img src="<?= $prodotto->immagine ?>" alt="<?= $prodotto->titolo ?>" class="img-fluid">
                </div>
                <div class="col-md-6">
                    <h5><?= $prodotto->titolo ?></h5>
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
        <?php } ?>
            <!-- totale del carrello-->
        <h3 class="text-end">Totale: €<?= number_format($total, 2, ',', '.') ?></h3>
    <?php } ?>

    <!-- procedi al checkout (solamente visuale con pagina di conferma pagamento) -->
    <div class="text-end">
        <a href="Structure/confirm.html" class="btn btn-success mt-3">Procedi al Checkout</a>
    </div>
</div>

<?php
require "Structure/footer.php";
?>
