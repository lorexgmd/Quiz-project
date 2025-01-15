<?php
session_start();
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz App</title>
    <link rel="stylesheet" href="styles/style.css">
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
        <div class="container">
            <h2>Welkom bij de Quiz App</h2>
            <?php if (isset($_SESSION['user_id'])): ?>
                <h3><?php echo $_SESSION['username']?></h3>
            <?php else: ?>
                <h3>Je bent niet ingelogd.</h3>
            <?php endif;?>
            <?php
            if (isset($_SESSION['user_id'])): ?>
                <p>Je bent ingelogd als <?php echo $_SESSION['role'];
            endif;
            ?>
            <p>Test je kennis met onze uitdagende quizzen</p>
            <div class="cards"> 
                <div class="card"> 
                    <h3>Populaire Quizzen</h3>
                    <p>Ontdek onze meest gespeelde quizzen en test jezelf!</p>
                    <ul>
                        <li>Algemene Kennis</li>
                        <li>Wetenschap</li>
                        <li>Geschiedenis</li>
                    </ul>
                </div>
                <div class="card"> 
                    <h3>Jouw Statistieken</h3>
                    <p>Bekijk je voortgang en prestaties</p>
                    <ul>
                        <li>Voltooide quizzen: <span>0</span></li>
                        <li>Gemiddelde score: <span>-</span></li>
                    </ul>
                </div>
            </div>
            <button class="btn start-btn" onclick="startQuiz()">Start met Quizzen</button> 
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
    <script>
        function startQuiz() {
            window.location.href = "quizzen.php";
        }
    </script>
</body>
</html>  
