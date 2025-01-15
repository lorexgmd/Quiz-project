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
            
            session_regenerate_id(true);

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            
            $redirect = isset($_SESSION['redirect_url']) ? $_SESSION['redirect_url'] : 'index.php';
            header("Location: $redirect");
            exit;
        } else {
            echo "Ongeldige inloggegevens!";
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
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>

<header class="header">
        <div class="container">
            <h1 class="logo">QuizApp</h1>
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
    <h1>Login</h1>
    <p>Log in op uw account</p>

    <form action="login.php" method="POST">
        <label for="username">Gebruikersnaam:</label>
        <input type="text" name="username" id="username" placeholder="Voer je gebruikersnaam in" required>

        <br><label for="password">Wachtwoord:</label>
        <input type="password" name="password" id="password" placeholder="Voer je wachtwoord in" required>

        <br><button type="submit" class="btn-login">Login</button>

        <p class="login-link">
        Heb je nog geen account? <a href="register.php">Registreren</a>
      </p>
    </form>    
</div>
    </main>


    <footer class="footer">
        <div class="container footer-content"> 
            <div class="footer-section">
                <h4>QuizApp</h4>
                <p>Test je kennis en daag jezelf uit met onze quizzen.</p>
            </div>
            <div class="footer-section">
                <h4>Links</h4>
                <ul> 
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Quizzes</a></li>
                    <li><a href="#">Scores</a></li>
                    <li><a href="#">Over Ons</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Contact</h4>
                <p>Email: info@quizapp.nl</p>
                <p>Tel: 020-1234567</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© 2024 QuizApp. Alle rechten voorbehouden.</p>
        </div>
    </footer>

        </p>
    </form>
</div>
</body>
</html>
