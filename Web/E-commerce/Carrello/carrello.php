<?php
$title = 'Carrello';
require "../Structure/header.php";
?>

<div class="container mt-5 bg-body-tertiary rounded-3 px-5 py-4">
    <h1 class="text-center mb-4" id="cart-title">Il tuo Carrello</h1>
    <div id="cart-items" class="mb-4"></div>

    <!-- Campo per il codice sconto -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <input type="text" id="discount-code" class="form-control w-50" placeholder="Inserisci codice sconto">
        <button id="apply-discount" class="btn btn-primary ms-2">Applica</button>
    </div>

    <h3 id="cart-total" class="text-end text-success"></h3>
    <div class="text-end">
        <button id="checkout-button" class="btn btn-success">Procedi al Checkout</button>
    </div>
</div>


<?php
require "../Structure/footer.php";
?>

<script src="carrello.js"></script>
