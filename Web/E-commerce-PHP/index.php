<?php
$title = 'Home';
require "Structure/DbConn.php";
$conf = require 'Structure/db_conf.php';
$db = DbConn::getDb($conf);
require "Structure/header.php";

// Seleziona 3 prodotti casuali dal database
$query = "SELECT codice, titolo AS name, prezzo, immagine AS image FROM prodotti ORDER BY RAND() LIMIT 3";
$stm = $db->prepare($query);
$stm->execute();
$prodotti = $stm->fetchAll(PDO::FETCH_OBJ);
?>

<div class="container mt-5">
    <!-- Hero Section -->
    <div class="bg-body-tertiary text-center p-5 rounded-3">
        <h1 class="text-danger"><strong>E-COMMERCE</strong></h1>
        <p class="lead">Trova i migliori prodotti al miglior prezzo.</p>
        <a href="archivio.php" class="btn btn-dark btn-lg">Scopri i Prodotti</a>

        <div class="mt-4">
            <img src="Immagini/img-sito.webp" class="img-fluid rounded shadow-lg" alt="Immagine Home" id="img-home">
        </div>


    <h2 class="mt-5">Prodotti in Evidenza</h2>
    <div class="row mt-3">
        <?php foreach ($prodotti as $prodotto) : ?>
            <div class="col-md-4">
                <div class="card shadow-sm products">
                    <img src="<?= $prodotto->image ?>" class="card-img-top" alt="<?= $prodotto->name ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= $prodotto->name ?></h5>
                        <p class="card-text text-success">€<?= number_format($prodotto->prezzo, 2, ',', '.') ?></p>
                        <a href="prodotto.php?codice=<?= $prodotto->codice ?>" class="btn btn-dark">Vedi Prodotto</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        </div>
    </div>
</div>

<?php require "Structure/footer.php"; ?>
