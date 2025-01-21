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
                    <li><a href="scores.php">Scores</a></li>
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
        <div class="quiz-header">
            <p>Naam</p>
            <p>Functies</p>
        </div>
        <?php if (count($quizzes) > 0): ?>
            <?php foreach ($quizzes as $quiz): ?>
                <div class="quiz-item">
                    <p class="quiz-name"><?php echo htmlspecialchars($quiz['quiz_name']); ?></p>
                    <div class="quiz-actions">
                        <a href="editQuiz.php?quiz_id=<?php echo $quiz['quiz_id']; ?>" class="btn-edit">Bewerk</a>
                        <form action="deleteQuiz.php" method="post" onsubmit="return confirm('Weet je zeker dat je deze quiz wilt verwijderen?');">
                            <input type="hidden" name="quiz_id" value="<?php echo $quiz['quiz_id']; ?>">
                            <button type="submit" class="btn-delete">Verwijder</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Je hebt nog geen quizzen gemaakt.</p>
        <?php endif; ?>
        <button class="btnn" onclick="gotoQuiz()">Nieuwe quiz maken</button>
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
                    <li><a href="quizzen.php">Quizzes</a></li>
                    <li><a href="scores.php">Scores</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Contact</h4>
                <p>Email: info@hersenhap.nl</p>
                <p>Tel: 020-1234567</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© 2025 HersenHap. Alle rechten voorbehouden.</p>
        </div>
    </footer>

    <script>
        function gotoQuiz() {
            window.location.href = 'quiz.php';
        }
    </script>
</body>
</html>
