<?php
session_start();
$page = basename($_SERVER["SCRIPT_NAME"]);
?>

<!doctype html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= isset($title) ? htmlspecialchars($title) : 'E-Commerce FastRoute' ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="Styles/style.css">
    <link rel="icon" type="image/x-icon" href="Immagini/bag.ico">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body class="d-flex flex-column min-vh-100">

<nav class="navbar navbar-expand-lg bg-dark navbar-dark sticky-top py-3">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php"><strong>E-Commerce FastRoute</strong></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?= $page == 'index.php' ? 'active' : ''; ?>" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $page == 'archivio.php' ? 'active' : ''; ?>" href="archivio.php">Archivio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $page == 'carrello.php' ? 'active' : ''; ?>" href="carrello.php">Carrello</a>
                </li>
            </ul>

            <?php if (isset($_SESSION['username'])): ?>
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle" type="button" id="userMenu" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle"></i> <?= htmlspecialchars($_SESSION['username']) ?>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item text-danger" href="Login/logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
                    </ul>
                </div>
            <?php else: ?>
                <a class="btn btn-outline-light" href="Login/login.php"><i class="bi bi-box-arrow-in-right"></i> Login</a>
                <a class="btn btn-primary ms-2" href="Login/register.php"><i class="bi bi-person-plus"></i> Registrati</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<div class="container mt-5 flex-grow-1">
