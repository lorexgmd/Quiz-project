<?php
session_start();
require 'config.php';

function getQuizInfo($quiz_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM Quiz WHERE quiz_id = :quiz_id");
    $stmt->execute(['quiz_id' => $quiz_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getCorrectAnswers($quiz_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT q.question_id, q.question_text, o.option_id, o.option_text
                           FROM Questions q 
                           JOIN Options o ON q.question_id = o.question_id
                           WHERE q.quiz_id = :quiz_id AND o.is_correct = 1");
    $stmt->execute(['quiz_id' => $quiz_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$quiz_id = $_POST['quiz_id']; 

$quizInfo = getQuizInfo($quiz_id);

if (!$quizInfo) {
    die("Quiz niet gevonden.");
}

$correctAnswers = getCorrectAnswers($quiz_id);

$score = 0;
foreach ($correctAnswers as $correctAnswer) {
    if (isset($_POST['question_' . $correctAnswer['question_id']]) && 
        $_POST['question_' . $correctAnswer['question_id']] == $correctAnswer['option_id']) {
        $score++;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultaten - <?php echo htmlspecialchars($quizInfo['quiz_name']); ?></title>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/styleSubmitQuiz.css">
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

<main class="maain">
    <h1>Resultaten van de Quiz: <?php echo htmlspecialchars($quizInfo['quiz_name']); ?></h1>
    <p>Je hebt <strong><?php echo $score; ?></strong> van de <strong><?php echo count($correctAnswers); ?></strong> vragen goed beantwoord.</p>

    <h3>Je Antwoorden:</h3>
    <ul>
        <?php foreach ($correctAnswers as $correctAnswer): ?>
            <li>
            <strong> Vraag: </strong><?php echo htmlspecialchars($correctAnswer['question_text']); ?> 
                <br> <strong> Jouw antwoord: </strong>
                <?php 
                    $user_answer = isset($_POST['question_' . $correctAnswer['question_id']]) ? $_POST['question_' . $correctAnswer['question_id']] : 'Geen antwoord';
                    
                    $user_answer_text = 'Geen antwoord';
                    if ($user_answer != 'Geen antwoord') {
                        $stmt = $pdo->prepare("SELECT option_text FROM Options WHERE option_id = :option_id");
                        $stmt->execute(['option_id' => $user_answer]);
                        $user_answer_text = $stmt->fetchColumn();
                    }
                    echo htmlspecialchars($user_answer_text);
                ?>
                <br> <strong> Correct antwoord: </strong> <?php echo htmlspecialchars($correctAnswer['option_text']); ?>
            </li>
        <?php endforeach; ?>
    </ul>

    <a href="index.php" class="btn">Terug naar Home</a>
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
