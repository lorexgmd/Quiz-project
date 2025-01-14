<?php
    include 'functions.php';
    
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles/styleRegister.css">
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
                    <li><a href="#">Over Ons</a></li>
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
        Heb je al een account? <a href="login.php">Inloggen</a>
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

</body>
</html>