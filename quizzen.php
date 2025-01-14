<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title> 
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
        <div class="quiz-conteiner">
        <label for="quizSearch"></label>
        <input type="text" name="quizSearch" id="quizSearch" placeholder="Zoek een quiz..." required>
        <button class="btn-search">Zoek</button>
        <div class="quiz-section">
            <button class="btn-start">Start</button>
                <h1></h1>
                <p></p>
        </div>
        <div class="quiz-section">
            <button class="btn-start">Start</button>
            <h1></h1>
            <p></p>
        </div>

        <div class="quiz-section">
            <button class="btn-start">Start</button>
            <h1></h1>
            <p></p>
        </div>
        <div class="quiz-section">
            <button class="btn-start">Start</button>
            <h1></h1>
            <p></p>
        </div>
        </div>
        <button class="btn-1">1</button>
        <button class="btn-2">2</button>
        <button class="btn-3">3</button>
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