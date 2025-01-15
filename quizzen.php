<?php

session_start()
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title> 
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/styleQuiz.css">
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
        <div class="search-bar">
            <input type="text" placeholder="Zoek een quiz...">
            <button class="btn">Zoeken</button>
        </div>
        
        <div class="quiz-list">
            <div class="quiz-item">
                <h3>Algemene Kennis Quiz</h3>
                <p>20 vragen • Moeilijkheidsgraad: Gemiddeld</p>
                <p>Test je kennis over verschillende onderwerpen</p>
                <button class="btn start">Start</button>
            </div>
            <div class="quiz-item">
                <h3>Sport Quiz</h3>
                <p>15 vragen • Moeilijkheidsgraad: Makkelijk</p>
                <p>Alles over verschillende sporten en atleten</p>
                <button class="btn start">Start</button>
            </div>
            <div class="quiz-item">
                <h3>Geschiedenis Quiz</h3>
                <p>25 vragen • Moeilijkheidsgraad: Moeilijk</p>
                <p>Ontdek je kennis over historische gebeurtenissen</p>
                <button class="btn start">Start</button>
            </div>
            <div class="quiz-item">
                <h3>Film & TV Quiz</h3>
                <p>18 vragen • Moeilijkheidsgraad: Gemiddeld</p>
                <p>Test je kennis over films en televisieseries</p>
                <button class="btn start">Start</button>
            </div>
        </div>
        
        <div class="pagination">
            <button class="page">1</button>
            <button class="page">2</button>
            <button class="page">3</button>
            <span>...</span>
            <button class="page">10</button>
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