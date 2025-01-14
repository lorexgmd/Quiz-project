<?php

include 'functions.php';

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles/styleLogin.css">
</head>
<body>
<div class="form-container">
        <h1>Login</h1>
        <p>Log in op uw account</p>

    <form action="register.php" method="">

        <label for="username">Gebruikersnaam:</label>
        <input type="text" name="username" id="username" placeholder="Voer je gebruikersnaam in" required>

        <br><label for="password">Wachtwoord:</label>
        <input type="password" name="password" id="password" placeholder="Voer je password in" required>


        <br><button type="submit" class="btn-login">Login</button>

        <p class="login-link">
        Heb je nog geen account? <a href="#">Registreren</a>
      </p>
    </form>    
</body>
</html>