<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
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
    <main>
<div class="containerr">
        <h1>Mijn Profiel</h1>

        <div class="section">
            <h2>Persoonlijke Informatie</h2>
            <div class="form-group">
                <label>Gebruikersnaam</label>
                <input type="text" value="<?php if (isset($_SESSION['user_id'])){
        echo $_SESSION['username'];
    
    }
    ?>" disabled>
            </div>
            <div class="form-group">
                <label>Rol</label>
                <input type="text" value="Gebruiker" disabled>
            </div>
            <button class="btn">Gegevens Bijwerken</button>
        </div>

        <div class="section">
            <h2>Wachtwoord Wijzigen</h2>
            <div class="form-group">
                <label>Huidig Wachtwoord</label>
                <input type="password">
            </div>
            <div class="form-group">
                <label>Nieuw Wachtwoord</label>
                <input type="password">
            </div>
            <div class="form-group">
                <label>Bevestig Nieuw Wachtwoord</label>
                <input type="password">
            </div>
            <button class="btn btn-black">Wachtwoord Wijzigen</button>
        </div>
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
    <?php if (isset($_SESSION['user_id'])): ?>
        <?php if ($_SESSION['role'] == 'teacher'): ?>
            <a href="#">Maak quiz</a>
        <?php elseif ($_SESSION['role'] == 'student'): ?>
            <a href="#">Quiz</a>
        <?php endif; ?>
    <?php endif; ?>
</body>

</html>
