<?php
session_start();
$title = 'Login';
require '../Structure/DbConn.php';

$conf=require'../Structure/db_conf.php';

$db = DbConn::getDb($conf);

$error = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Query per ottenere i dati dell'utente dalla tabella "utenti"
    $query = "SELECT username, password FROM utenti WHERE username = :username";
    $stm = $db->prepare($query);
    $stm->bindParam(':username', $username, PDO::PARAM_STR);
    $stm->execute();
    $user = $stm->fetch(PDO::FETCH_OBJ);

    if ($user) {
        // Verifica della password hashata
        if (password_verify($password, $user->password)) {
            $_SESSION['username'] = $user->username;
            header("Location: ../index.php");
            exit();
        } else {
            $error = "Password errata.";
        }
    } else {
        $error = "Utente non trovato.";
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">Login</h1>

    <?php if ($error): ?>
        <div class="alert alert-danger text-center"><?= $error ?></div>
    <?php endif; ?>

    <form action="login.php" method="post" class="w-50 mx-auto">
        <div class="mb-3">
            <label for="username" class="form-label">Username:</label>
            <input type="text" name="username" id="username" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password:</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Accedi</button>
    </form>

    <div class="text-center mt-3">
        <a href="register.php">Non hai un account? Registrati</a>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
