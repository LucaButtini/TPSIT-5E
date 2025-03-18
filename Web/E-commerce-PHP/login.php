<?php
// Inizializza la sessione
session_start();

// Controlla se il modulo è stato inviato
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera i dati dal modulo
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Qui dovresti aggiungere la logica per verificare le credenziali dell'utente
    // Ad esempio, controllando un database

    // Per ora, simuleremo un login di successo se l'email è "test@example.com" e la password è "password"
    if ($email === "test@example.com" && $password === "password") {
        $_SESSION['loggedin'] = true;
        $_SESSION['email'] = $email;
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
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Inserisci la tua email" required>
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