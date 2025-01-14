<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        echo "Vul alle velden in!";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            header("Location: index.php");
            exit;
        } else {
            echo "Ongeldige gebruikersnaam of wachtwoord!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles/styleLogin.css">
</head>
<body>
<div class="form-container">
    <h1>Login</h1>
    <p>Log in op uw account</p>

    <form action="login.php" method="POST">
        <label for="username">Gebruikersnaam:</label>
        <input type="text" name="username" id="username" placeholder="Voer je gebruikersnaam in" required>

        <br><label for="password">Wachtwoord:</label>
        <input type="password" name="password" id="password" placeholder="Voer je password in" required>

        <br><button type="submit" class="btn-login">Login</button>

        <p class="login-link">
        Heb je nog geen account? <a href="register.php">Registreren</a>
        </p>
    </form>
</div>
</body>
</html>
