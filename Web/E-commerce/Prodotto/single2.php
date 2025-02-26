<?php
$title = 'Dettagli Prodotto';
require "../Structure/header.php";
?>

<div class="container mt-5 bg-body-tertiary rounded-3 px-5 py-4">
    <div class="row">
        <div class="col-md-6 text-center">
            <img src="" class="img-fluid w-75 rounded-3 products" alt="Immagine Prodotto">
        </div>
        <div class="col-md-6">
            <h1 id="product-title"></h1>
            <p class="text-muted" id="product-code"></p>
            <h2 class="text-success" id="product-price"></h2>
            <p class="lead" id="product-description"></p>

            <!-- Varianti di prodotto -->
            <div class="mt-3">
                <label for="taglia">Taglia:</label>
                <select id="taglia" class="form-select w-50 mb-3">
                    <option value="S">S</option>
                    <option value="M">M</option>
                    <option value="L">L</option>
                    <option value="XL">XL</option>
                </select>

                <label for="colore">Colore:</label>
                <select id="colore" class="form-select w-50 mb-3">
                    <option value="Nero">Nero</option>
                    <option value="Bianco">Bianco</option>
                    <option value="Blu">Blu</option>
                    <option value="Rosso">Rosso</option>
                </select>
            </div>

            <div class="mt-4">
                <label for="quantita" id="quantity-label"></label>
                <input type="number" id="quantita" name="quantita" value="1" min="1" class="form-control w-25 mb-3">
                <button id="add-to-cart-button" class="btn btn-dark btn-lg"></button>
            </div>
        </div>
    </div>

    <!-- Tabella delle caratteristiche tecniche -->
    <div class="mt-5">
        <h3 class="text-info">Caratteristiche Tecniche</h3>
        <table class="table table-bordered">
            <tbody id="technical-details">
            <!-- Qui verranno inserite le caratteristiche -->
            </tbody>
        </table>
    </div>

    <div class="mt-5">
        <h3 class="text-info" id="reviews-title"></h3>
        <div id="reviews"></div>
    </div>
</div>

<?php
require "../Structure/footer.php";
?>

<script src="single2.js"></script>
