<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    die("Je moet ingelogd zijn om quizzen te beheren.");
}

$user_id = $_SESSION['user_id'];

function getUserQuizzes($user_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM Quiz WHERE created_by = :user_id");
    $stmt->execute(['user_id' => $user_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$quizzes = getUserQuizzes($user_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mijn Quizzen</title>
    <link rel="stylesheet" href="styles/Style.css">
    <link rel="stylesheet" href="styles/teacher.css">
</head>
<body>

<header class="header">
        <div class="container">
            <h1 class="logo">HersenHap</h1>
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
    <h1>Beheer mijn quizzen</h1>
    <div class="card">
        <div class="row">
            <div class="column">
            <p class="ppp">Naam</p>
    <?php if (count($quizzes) > 0): ?>
            <?php foreach ($quizzes as $quiz): ?>
                    <?php echo htmlspecialchars($quiz['quiz_name']); ?>
            </div>
            <div class="column">
                <p class="ppp">Functies</p>
                    <a href="editQuiz.php?quiz_id=<?php echo $quiz['quiz_id']; ?>">Bewerk</a>
                    <form action="deleteQuiz.php" method="post" style="display:inline;" onsubmit="return confirm('Weet je zeker dat je deze quiz wilt verwijderen?');">
                        <input type="hidden" name="quiz_id" value="<?php echo $quiz['quiz_id']; ?>">
                        <button class="bton" type="submit">Verwijder</button>
                    </form>
                    </div>
            <?php endforeach; ?>
    <?php else: ?>
        <p>Je hebt nog geen quizzen gemaakt.</p>
    <?php endif; ?>
    </div>
    <button class="btn" href="quiz.php">Nieuwe quiz maken</button>
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
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Quizzes</a></li>
                    <li><a href="#">Scores</a></li>
                    <li><a href="#">Over Ons</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Contact</h4>
                <p>Email: info@hersenhap.nl</p>
                <p>Tel: 020-1234567</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© 2024 HersenHap. Alle rechten voorbehouden.</p>
        </div>
    </footer>
</body>
</html>
