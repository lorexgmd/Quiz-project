<?php
require 'config.php'; // Maak verbinding met de database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Haal de gegevens uit het formulier
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Controleer of alle velden ingevuld zijn
    if (empty($username) || empty($password) || empty($role)) {
        echo "Alle velden zijn verplicht!";
    } else {
        // Controleer of de gebruikersnaam al bestaat
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        if ($stmt->rowCount() > 0) {
            echo "Gebruikersnaam bestaat al!";
        } else {
            // Hash het wachtwoord
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // Voeg de gebruiker toe aan de database
            $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (:username, :password, :role)");
            $stmt->execute([
                'username' => $username,
                'password' => $hashedPassword,
                'role' => $role
            ]);

            echo "Registratie succesvol! <a href='login.php'>Log hier in</a>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registreren</title>
    <link rel="stylesheet" href="styles/styleRegister.css">
</head>

<body>
    <div class="form-container">
        <h1>Registreren</h1>
        <p>Maak een nieuw account aan</p>

        <form action="register.php" method="POST">

            <label for="username">Gebruikersnaam:</label>
            <input type="text" name="username" id="username" placeholder="Voer je gebruikersnaam in" required>

            <br><label for="password">Wachtwoord:</label>
            <input type="password" name="password" id="password" placeholder="Voer je wachtwoord in" required>

            <p class="Select">Selecteer je rol </p>
            <div class="role-selection">
                <label>
                    <input type="radio" name="role" value="teacher" required> Leraar
                </label>
                <label>
                    <input type="radio" name="role" value="student" required> Leerling
                </label>
            </div>

            <br><button type="submit" class="btn-register">Registreren</button>

            <p class="login-link">
                Heb je al een account? <a href="login.php">Inloggen</a>
            </p>
        </form>
    </div>
</body>

</html>
