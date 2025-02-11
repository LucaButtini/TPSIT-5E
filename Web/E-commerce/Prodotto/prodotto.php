<?php
$title='Prodotto';
require "../Structure/header.php";

?>

    <div class="container mt-5 bg-body-tertiary rounded-3 px-5 py-4">
        <div class="row">
            <div class="col-md-6 text-center">
                <img src="" class="img-fluid w-75 rounded-3 border border-dark"
                    alt="Immagine Prodotto">
            </div>
            <div class="col-md-6">
                <h1 id="product-title"></h1>
                <p class="text-muted" id="product-code"></p>
                <h2 class="text-success" id="product-price"></h2>
                <p class="lead" id="product-description"></p>
                <div class="mt-4">
                    <label for="quantita" id="quantity-label"></label>
                    <input type="number" id="quantita" name="quantita" value="1" min="1" class="form-control w-25 mb-3">
                    <button id="add-to-cart-button" class="btn btn-dark btn-lg"></button>
                </div>
            </div>
        </div>

        <div class="mt-5">
            <h3 id="description-title"></h3>
            <p id="detailed-description"></p>
            <h3 id="reviews-title"></h3>
            <div id="reviews"></div>
        </div>
    </div>

<?php
require "../Structure/footer.php";
?>

<script src="prodotto.js"></script>
