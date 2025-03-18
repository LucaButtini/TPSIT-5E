<?php
// Inizializza la sessione
session_start();

// Controlla se l'utente è già loggato
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("location: welcome.php"); // Se l'utente è già loggato, reindirizzalo
    exit;
}

// Controlla se il modulo è stato inviato
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera i dati dal modulo
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Simuliamo una verifica (dovresti fare una query sul database)
    // Ad esempio, verifica se l'username e la password corrispondono a quelli nel database
    if ($username === "testuser" && $password === "password") {
        // Crea le variabili di sessione
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        header("location: welcome.php"); // Reindirizza a una pagina di benvenuto
        exit;
    } else {
        $error = "Credenziali non valide.";
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="Styles/style.css">
</head>
<body id="login-body">

<div class="login-card">
    <h2>Accedi</h2>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>
    <form method="post" action="">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Inserisci il tuo username" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Inserisci la tua password" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Accedi</button>
        <button type="button" class="btn btn-google btn-block">Accedi con Google</button>
    </form>
    <div class="text-center mt-3">
        <a href="#">Hai dimenticato la password?</a>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
