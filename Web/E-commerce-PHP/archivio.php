<?php
$title = 'Archivio';
require 'Structure/DbConn.php';
$conf = require 'Structure/db_conf.php';
$db = DbConn::getDB($conf);
require "Structure/header.php";

// Recupera i prodotti dal database
$query = "SELECT codice, titolo AS name, prezzo, immagine AS image, descrizione FROM prodotti";
$stm = $db->prepare($query);
$stm->execute();
$prodotti = $stm->fetchAll();
?>

<div class="container mt-5 bg-body-tertiary rounded-3 px-5 py-5">
    <h1 class="text-center mb-4"><strong>Archivio Prodotti</strong></h1>
    <div class="row">
        <?php foreach ($prodotti as $prodotto) { // stampa prodotti archivio?>
            <div class="col-md-4 mb-4">
                <div class="card h-100 products">
                    <img src="<?= $prodotto->image ?>" class="card-img-top" alt="<?= $prodotto->name ?>">
                    <div class="card-body">
                        <h5 class="card-title"><strong><?= $prodotto->name ?></strong></h5>
                        <p class="card-text"><?= $prodotto->descrizione ?></p>
                        <h6 class="text-success">€<?= number_format($prodotto->prezzo, 2, ',', '.') ?></h6>
                        <a href="prodotto.php?codice=<?= $prodotto->codice ?>" class="btn btn-dark w-100">Visualizza Dettagli</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<?php
require "Structure/footer.php";
?>
