<?php
$title = 'Home';
require "../Structure/header.php";
?>

<div class="container mt-5">
    <!-- Hero Section -->
    <div class="bg-body-tertiary text-center p-5 rounded-3">
        <h1 class="text-danger"><strong>E-COMMERCE</strong></h1>
        <p class="lead">Trova i migliori prodotti al miglior prezzo.</p>
        <a href="../Prodotto/prodotto.php" class="btn btn-success btn-lg">Scopri i Prodotti</a>
    </div>

    <!-- Sezione Prodotti in Evidenza -->
    <h2 class="mt-5">Prodotti in Evidenza</h2>
    <div class="row mt-3" id="featured-products"></div>
</div>

<?php
require "../Structure/footer.php";
?>

<script src="home.js"></script>
