<?php
    include 'functions.php';
    databaseConnect();
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles/styleRegister.css">
</head>
<body>
    <div class="form-container">
        <h1>Registreren</h1>
        <p>Maak een nieuw account aan</p>

    <form action="register.php" method="">

        <label for="username">Gebruikersnaam:</label>
        <input type="text" name="username" id="username" placeholder="Voer je gebruikersnaam in" required>

        <br><label for="password">Wachtwoord:</label>
        <input type="password" name="password" id="password" placeholder="Voer je password in" required>

        <p class="Select">Selecteer je rol </p>
        <div class="role-selection">
    <label>
        <input type="radio" name="role" value="teacher"> Leraar
    </label>
    <label>
        <input type="radio" name="role" value="student"> Leerling
    </label>
</div>


        <br><button type="submit" class="btn-register">Registreren</button>

        <p class="login-link">
        Heb je al een account? <a href="#">Inloggen</a>
      </p>
    </form>     
</div>
</body>
</html>