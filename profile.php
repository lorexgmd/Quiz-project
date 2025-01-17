<?php
session_start();

// Connect de database in deze file 
require 'config.php';

// Als client niet is ingelogd dan stuur hij je naar index.php
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

// Veranderen van wachtwoorden in database met ingevulde gegevens van de form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];
    $user_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :user_id");
    $stmt->execute(['user_id' => $user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($currentPassword, $user['password'])) {
        if ($newPassword == $confirmPassword) {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE users SET password = :password WHERE id = :user_id");
            $stmt->execute(['password' => $hashedPassword, 'user_id' => $user_id]);
            $_SESSION['success'] = "Wachtwoord succesvol gewijzigd.";
        } else {
            $_SESSION['error'] = "Nieuw wachtwoord en bevestiging komen niet overeen.";
        }
    }
}
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/profile.css">
</head>

<body>
    <header class="header">
        <div class="container">
            <h1 class="logo">QuizApp</h1>
            <nav>
                <ul class="nav-links">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="quizzen.php">Quizzes</a></li>
                    <li><a href="#">Scores</a></li>
                </ul>
            </nav>

            <div class="auth-buttons">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="logout.php" class="btn logout">Uitloggen</a>
                    <a href="profile.php" class="btn profile">Profiel</a>
                <?php else: ?>
                    <a href="login.php" class="btn login">Login</a>
                    <a href="register.php" class="btn signup">Sign Up</a>
                <?php endif; ?>
            </div>
        </div>
    </header>
    <main class="main">
        <div class="containerr">
            <h1>Mijn Profiel</h1>

            <div class="section">
                <h2>Persoonlijke Informatie</h2>
                <div class="form-group">
                    <label>Gebruikersnaam</label>
                    <input type="text" value="<?php if (isset($_SESSION['user_id'])) {
                        echo $_SESSION['username'];

                    }
                    ?>" disabled>
                </div>
                <div class="form-group">
                    <label>Rol</label>
                    <input type="text" value="<?php echo $_SESSION['role']; ?>" disabled>
                </div>

                <button class="btn">Gegevens Bijwerken</button>
            </div>

            <form action="profile.php" method="POST">
                <div class="section">
                    <h2>Wachtwoord wijzigen</h2>
                    <div class="form-group">
                        <label for="current_password">Huidig wachtwoord</label>
                        <input type="password" name="current_password" id="current_password" required>
                    </div>
                    <div class="form-group">
                        <label for="new_password">Nieuw wachtwoord</label>
                        <input type="password" name="new_password" id="new_password" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Bevestig nieuw wachtwoord</label>
                        <input type="password" name="confirm_password" id="confirm_password" required>
                    </div>
                    <button type="submit" class="btn btn-black">Wachtwoord wijzigen</button>
                </div>
            </form>
            <?php if (isset($_SESSION['user_id'])): ?>
                <?php if ($_SESSION['role'] == 'teacher'): ?>
                    <a href="teacher.php" class="teacherLink">Beheer quiz</a>
                <?php endif; ?>
            <?php endif; ?>

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
</body>

</html>