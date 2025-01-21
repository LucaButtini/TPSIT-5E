<?php

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Articolo</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"><strong>E-Commerce</strong></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Prodotti</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Carrello</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">Registrati/Accedi</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5 bg-body-tertiary rounded-3 px-5 py-4">
    <!-- Dettagli prodotto -->
    <div class="row">
        <!-- Immagine prodotto -->
        <div class="col-md-6 text-center">
            <img src="../E-commerce/Immagini/p1.webp"
                 class="img-fluid w-75 rounded-3 border border-dark"
                 alt="Immagine Prodotto">
        </div>

        <!-- Descrizione prodotto -->
        <div class="col-md-6">
            <h1 class="display-5"><strong>Esempio Prodotto</strong></h1>
            <p class="text-muted">Codice: <strong>#12345</strong></p>
            <h2 class="text-success">€49,99</h2>
            <p class="lead">
                Questo è un prodotto di alta qualità perfetto per le tue esigenze. È realizzato con materiali resistenti
                e offre un design moderno e funzionale.
            </p>
            <div class="mt-4">
                <label for="quantita" class="form-label">Quantità:</label>
                <input type="number" id="quantita" name="quantita" value="1" min="1" class="form-control w-25 mb-3">
                <button class="btn btn-dark btn-lg"><i class="bi bi-cart-plus"></i> Aggiungi al Carrello</button>
            </div>
        </div>
    </div>

    <!--descrizioni e recensioni-->
    <div class="mt-5">
        <h3>Descrizione Prodotto</h3>
        <p>
            Questo prodotto è stato progettato per soddisfare le esigenze dei nostri clienti. La sua versatilità lo rende adatto
            a diverse situazioni, garantendo comfort e durata. È disponibile in diverse varianti per adattarsi ai tuoi gusti.
        </p>
        <h3>Recensioni Clienti</h3>
        <div class="border p-3 mb-3">
            <p><strong>Mario Rossi</strong> <span class="text-warning">★★★★★</span></p>
            <p>Prodotto eccellente! Lo consiglio vivamente.</p>
        </div>
        <div class="border p-3">
            <p><strong>Lucia Bianchi</strong> <span class="text-warning">★★★★☆</span></p>
            <p>Buona qualità, ma la consegna ha impiegato più tempo del previsto.</p>
        </div>
    </div>
</div>

<footer>
    <div class="bg-dark py-5 mt-5 text-center rounded-3"> <!-- Aggiunto rounded-3 -->
        <p class="display-6 mb-3 text-white">Buttini Luca 5-E</p>
        <small class="text-white-50">&copy; 2025 E-Commerce. All rights reserved.</small>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
