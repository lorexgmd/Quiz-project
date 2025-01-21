<?php
session_start();
require 'config.php'; 

function getQuizInfo($quiz_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM Quiz WHERE quiz_id = :quiz_id");
    $stmt->execute(['quiz_id' => $quiz_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getQuestionsAndOptions($quiz_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM Questions WHERE quiz_id = :quiz_id");
    $stmt->execute(['quiz_id' => $quiz_id]);
    $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $questionsWithOptions = [];
    foreach ($questions as $question) {
        $stmt = $pdo->prepare("SELECT * FROM Options WHERE question_id = :question_id");
        $stmt->execute(['question_id' => $question['question_id']]);
        $options = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $questionsWithOptions[] = [
            'question' => $question,
            'options' => $options
        ];
    }

    return $questionsWithOptions;
}

if (!isset($_GET['quiz_id'])) {
    die("Quiz ID niet gevonden.");
}

$quiz_id = $_GET['quiz_id'];
$quizInfo = getQuizInfo($quiz_id);

if (!$quizInfo) {
    die("Quiz niet gevonden.");
}

$questionsWithOptions = getQuestionsAndOptions($quiz_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Speel Quiz - <?php echo htmlspecialchars($quizInfo['quiz_name']); ?></title>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/stylePlayQuiz.css">
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
    <h1><?php echo htmlspecialchars($quizInfo['quiz_name']); ?></h1>
    <p>Test je kennis over verschillende onderwerpen!</p>

    <form action="submitQuiz.php" method="post">
        <input type="hidden" name="quiz_id" value="<?php echo $quiz_id; ?>">

        <?php foreach ($questionsWithOptions as $index => $questionWithOptions): ?>
            <div class="quiz-question">
                <p><?php echo htmlspecialchars($questionWithOptions['question']['question_text']); ?></p>
                <?php foreach ($questionWithOptions['options'] as $option): ?>
                    <div class="option">
                        <input type="radio" 
                               id="q<?php echo $index; ?>_option<?php echo $option['option_id']; ?>" 
                               name="question_<?php echo $questionWithOptions['question']['question_id']; ?>" 
                               value="<?php echo $option['option_id']; ?>" required>
                        <label for="q<?php echo $index; ?>_option<?php echo $option['option_id']; ?>"><?php echo htmlspecialchars($option['option_text']); ?></label>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>

        <button type="submit" class="btn">Verstuur Quiz</button>
    </form>
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
                <li><a href="#">Scores</a></li>
            </ul>
        </div>
        <div class="footer-section">
            <h4>Contact</h4>
            <p>Email: info@quizapp.nl</p>
            <p>Tel: 020-1234567</p>
        </div>
    </div>
    <div class="footer-bottom">
        <p>© 2025 HersenHap. Alle rechten voorbehouden.</p>
    </div>
</footer>
</body>
</html>
