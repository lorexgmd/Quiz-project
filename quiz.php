<?php
session_start();

require 'config.php';
require_once 'classes/Quiz.php';

set_time_limit(300);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $creator = htmlspecialchars($_POST['creator']);
    
    $questions = [];
    $options = [];
    $answers = [];

    foreach ($_POST['questions'] as $key => $question) {
        if (!empty($question)) {
            $questions[] = htmlspecialchars($question);
            $options[] = array_map('trim', explode(',', $_POST['options'][$key]));
            $answers[] = htmlspecialchars($_POST['answers'][$key]);
        }
    }

    $quiz = new Quiz($name, $creator, $questions);

    try {
        $pdo->beginTransaction();

        $stmt = $pdo->prepare("INSERT INTO Quiz (quiz_name, created_by) VALUES (?, ?)");
        $stmt->execute([$quiz->getName(), $quiz->getCreator()]);
        $quizId = $pdo->lastInsertId();

        foreach ($quiz->getQuestions() as $index => $questionText) {
            $stmt = $pdo->prepare("INSERT INTO Questions (quiz_id, question_text) VALUES (?, ?)");
            $stmt->execute([$quizId, $questionText]);
            $questionId = $pdo->lastInsertId();

            foreach ($options[$index] as $optionText) {
                $isCorrect = ($answers[$index] === $optionText) ? 1 : 0;
                $stmt = $pdo->prepare("INSERT INTO Options (question_id, option_text, is_correct) VALUES (?, ?, ?)");
                $stmt->execute([$questionId, $optionText, $isCorrect]);
            }
        }

        $pdo->commit();

        echo "Quiz succesvol opgeslagen!";
    } catch (PDOException $e) {
        $pdo->rollBack();
        echo "Fout bij het opslaan van de quiz: " . $e->getMessage();
    }
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maak een Quiz</title>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/styleQuizMaken.css">
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
    <h1>Maak een nieuwe quiz</h1>
    <form action="quiz.php" method="POST">
        <label for="name">Quiznaam:</label><br>
        <input type="text" id="name" name="name" required><br><br>

        <label for="creator">Maker:</label><br>
        <input type="text" id="creator" name="creator" required><br><br>

        <div id="questions-section">
            <div class="question-entry">
                <h3>Vraag 1</h3>
                <label for="questions[]">Vraag:</label><br>
                <input type="text" name="questions[]" required><br><br>

                <label for="options[]">Opties (gescheiden door komma's):</label><br>
                <input type="text" name="options[]" required><br><br>

                <label for="answers[]">Correcte antwoord:</label><br>
                <input type="text" name="answers[]" required><br><br>
            </div>
        </div>

        <button type="button" id="add-question">Voeg vraag toe</button><br><br>
        <button type="submit">Quiz opslaan</button>
    </form>
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
        let questionCount = 1;

       
        document.getElementById('add-question').addEventListener('click', function() {
            questionCount++;

            const newQuestionDiv = document.createElement('div');
            newQuestionDiv.classList.add('question-entry');
            newQuestionDiv.innerHTML = `
                <h3>Vraag ${questionCount}</h3>
                <label for="questions[]">Vraag:</label><br>
                <input type="text" name="questions[]" required><br><br>

                <label for="options[]">Opties (gescheiden door komma's):</label><br>
                <input type="text" name="options[]" required><br><br>

                <label for="answers[]">Correcte antwoord:</label><br>
                <input type="text" name="answers[]" required><br><br>
            `;

            document.getElementById('questions-section').appendChild(newQuestionDiv);
        });
    </script>
</body>
</html>
