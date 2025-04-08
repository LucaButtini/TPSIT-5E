<?php
session_start();
$title = 'Registrazione';
// connessione al database
require '../Structure/DbConn.php';

$conf = require'../Structure/db_conf.php';
$db = DbConn::getDb($conf);

$error = "";
$message = "";

//prendo dati dal form
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    // Controllo se le password coincidono
    if ($password !== $password_confirm) {
        $error = "Le password non coincidono.";
    } else {
        // guardo se c'è già utente
        $query = "SELECT username FROM utenti WHERE username = :username";
        $stm = $db->prepare($query);
        $stm->bindParam(':username', $username);
        $stm->execute();

        if ($stm->fetch()) {
            $error = "Utente già esistente.";
        } else {
            // nuovo utente con la password hashata
            $hash = password_hash($password, PASSWORD_DEFAULT);
            try {
                //query inserimento utente
                $query_insert = "INSERT INTO utenti (username, password) VALUES (:username, :password)";
                $stm = $db->prepare($query_insert);
                $stm->bindParam(':username', $username);
                $stm->bindParam(':password', $hash);
                //messaggi di errore o conferma
                if ($stm->execute()) {
                    $message = "Registrazione avvenuta con successo. Puoi ora effettuare il login.";
                } else {
                    $error = "Errore durante la registrazione.";
                }
            } catch (PDOException $e) {
                $error = "Errore di connessione al database: " . $e->getMessage();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Registrazione</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">Registrazione</h1>

    <?php if ($error){ //messaggio di conferma?>
        <div class="alert alert-danger text-center"><?= $error ?></div>
    <?php } ?>

    <?php if ($message){ //messaggio di errore?>
        <div class="alert alert-success text-center"><?= $message ?></div>
    <?php } ?>

    <!-- form registrazione utente -->
    <form action="register.php" method="post" class="w-50 mx-auto">
        <div class="mb-3">
            <label for="username" class="form-label">Username:</label>
            <input type="text" name="username" id="username" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password:</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="password_confirm" class="form-label">Conferma Password:</label>
            <input type="password" name="password_confirm" id="password_confirm" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Registrati</button>
    </form>
    <!-- login link  -->
    <div class="text-center mt-3">
        <a href="login.php">Hai già un account? Effettua il login.</a>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
