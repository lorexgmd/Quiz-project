<?php
require 'config.php';
include 'bannedUsernames.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $role = $_POST['role'];

    if (empty($username) || empty($password) || empty($role)) {
        echo "Alle velden zijn verplicht!";
    } else {
        if (in_array($username, $forbidden_usernames)){
            echo "Gebruikersnaam staat in blacklist!";
        } else {
            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
            $stmt->execute(['username' => $username]);
            if ($stmt->rowCount() > 0) {
                echo "Gebruikersnaam bestaat al!";
            } else {
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

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
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registreren</title>
    <link rel="stylesheet" href="styles/styleRegister.css">
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>

    <header class="header">
        <div class="container">
            <h1 class="logo">HersenHap</h1>
            <nav>
                <ul class="nav-links">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="#">Quizzes</a></li>
                    <li><a href="#">Scores</a></li>
                </ul>
            </nav>
            <div class="auth-buttons">
                <a href="login.php" class="btn login">Login</a>
                <a href="register.php" class="btn signup">Sign Up</a>
            </div>
        </div>
    </header>




    <main class="main">
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
    </main>


    <footer class="footer">
        <div class="container footer-content">
            <div class="footer-section">
                <h4>HersenHap</h4>
                <p>Test je kennis en daag jezelf uit met onze quizzen.</p>
            </div>
            <div class="footer-section">
                <h4>Links</h4>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="quizzen">Quizzes</a></li>
                    <li><a href="#">Scores</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Contact</h4>
                <p>Email: info@quizapp.nl</p>
                <p>Tel: 020-1234567</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© 2025 HersenHap. Alle rechten voorbehouden.</p>
        </div>
    </footer>


    <p class="login-link">
        Heb je al een account? <a href="login.php">Inloggen</a>
    </p>
    </form>
    </div>
</body>

</html>