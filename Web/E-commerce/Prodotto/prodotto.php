<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../Styles/style.css">
    <title>Prodotto</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" id="navbar-brand"><strong></strong></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav" id="navbar-links"></ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5 bg-body-tertiary rounded-3 px-5 py-4">
        <div class="row">
            <div class="col-md-6 text-center">
                <img src="../c" class="img-fluid w-75 rounded-3 border border-dark"
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

    <footer>
        <div class="bg-dark py-5 mt-5 text-center rounded-3">
            <p id="footer-author" class="display-6 mb-3 text-white"></p>
            <small id="footer-copyright" class="text-white-50"></small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="prodotto.js"></script>
</body>

</html>