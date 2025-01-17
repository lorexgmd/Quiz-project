<?php
session_start();

require 'config.php';

if (!isset($_SESSION['user_id'])) {
    die("Je moet ingelogd zijn om een quiz te bewerken.");
}

$user_id = $_SESSION['user_id'];
$quiz_id = $_GET['quiz_id'] ?? null;

if (!$quiz_id) {
    die("Geen quiz geselecteerd.");
}

$stmt = $pdo->prepare("SELECT * FROM Quiz WHERE quiz_id = :quiz_id AND created_by = :user_id");
$stmt->execute(['quiz_id' => $quiz_id, 'user_id' => $user_id]);
$quiz = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$quiz) {
    die("Quiz niet gevonden of je hebt geen rechten om deze te bewerken.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_quiz'])) {
    $quiz_name = $_POST['quiz_name'];
    $stmt = $pdo->prepare("UPDATE Quiz SET quiz_name = :quiz_name WHERE quiz_id = :quiz_id AND created_by = :user_id");
    $stmt->execute(['quiz_name' => $quiz_name, 'quiz_id' => $quiz_id, 'user_id' => $user_id]);

    header("Location: editQuiz.php?quiz_id=$quiz_id");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_question'])) {
    $question_id = $_POST['question_id'];
    $question_text = $_POST['question_text'];

    $stmt = $pdo->prepare("UPDATE Questions SET question_text = :question_text WHERE question_id = :question_id");
    $stmt->execute(['question_text' => $question_text, 'question_id' => $question_id]);

    header("Location: editQuiz.php?quiz_id=$quiz_id");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_question'])) {
    $question_id = $_POST['question_id'];

    $stmt = $pdo->prepare("DELETE FROM Options WHERE question_id = :question_id");
    $stmt->execute(['question_id' => $question_id]);

    $stmt = $pdo->prepare("DELETE FROM Questions WHERE question_id = :question_id");
    $stmt->execute(['question_id' => $question_id]);

    header("Location: editQuiz.php?quiz_id=$quiz_id");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_question'])) {
    $question_text = $_POST['question_text'];

    $stmt = $pdo->prepare("INSERT INTO Questions (quiz_id, question_text) VALUES (:quiz_id, :question_text)");
    $stmt->execute(['quiz_id' => $quiz_id, 'question_text' => $question_text]);

    header("Location: editQuiz.php?quiz_id=$quiz_id");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_option'])) {
    $option_id = $_POST['option_id'];
    $option_text = $_POST['option_text'];

    $stmt = $pdo->prepare("UPDATE Options SET option_text = :option_text WHERE option_id = :option_id");
    $stmt->execute(['option_text' => $option_text, 'option_id' => $option_id]);

    header("Location: editQuiz.php?quiz_id=$quiz_id");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_option'])) {
    $option_id = $_POST['option_id'];

    $stmt = $pdo->prepare("DELETE FROM Options WHERE option_id = :option_id");
    $stmt->execute(['option_id' => $option_id]);

    header("Location: editQuiz.php?quiz_id=$quiz_id");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_option'])) {
    $question_id = $_POST['question_id'];
    $option_text = $_POST['option_text'];

    $stmt = $pdo->prepare("INSERT INTO Options (question_id, option_text, is_correct) VALUES (:question_id, :option_text, :is_correct)");
    $stmt->execute(['question_id' => $question_id, 'option_text' => $option_text, 'is_correct' => 0]);

    header("Location: editQuiz.php?quiz_id=$quiz_id");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['toggle_correct'])) {
    $option_id = $_POST['option_id'];
    $is_correct = $_POST['is_correct'] == 1 ? 0 : 1;

    $stmt = $pdo->prepare("UPDATE Options SET is_correct = :is_correct WHERE option_id = :option_id");
    $stmt->execute(['is_correct' => $is_correct, 'option_id' => $option_id]);

    header("Location: editQuiz.php?quiz_id=$quiz_id");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM Questions WHERE quiz_id = :quiz_id");
$stmt->execute(['quiz_id' => $quiz_id]);
$questions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <title>Quiz bewerken</title>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/editQuiz.css">
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
        <h1>Quiz bewerken</h1>
        <form action="" method="post">
            <label for="quiz_name">Quiznaam:</label>
            <input type="text" name="quiz_name" id="quiz_name"
                value="<?php echo htmlspecialchars($quiz['quiz_name']); ?>" required>
            <button type="submit" name="update_quiz">Opslaan</button>
        </form>

        <h2>Vragen</h2>
        <?php
        $index = 1;
        foreach ($questions as $question): ?>
            <h3>Vraag <?= $index ?></h3>
            <form action="" method="post">
                <input type="hidden" name="question_id" value="<?= $question['question_id'] ?>">
                <input type="text" name="question_text" value="<?= htmlspecialchars($question['question_text']) ?>"
                    required>
                <button type="submit" name="update_question">Bewerken</button>
                <button type="submit" name="delete_question">Verwijderen</button>
            </form>

            <h4>Opties</h4>
            <?php
            $stmt = $pdo->prepare("SELECT * FROM Options WHERE question_id = :question_id");
            $stmt->execute(['question_id' => $question['question_id']]);
            $options = $stmt->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <?php foreach ($options as $option): ?>
                <form action="" method="post" style="display: flex; align-items: center;">
                    <input type="hidden" name="option_id" value="<?= $option['option_id'] ?>">
                    <input type="hidden" name="is_correct" value="<?= $option['is_correct'] ?>">
                    <input type="text" name="option_text" value="<?= htmlspecialchars($option['option_text']) ?>" required>
                    <button type="submit" name="update_option">Bewerken</button>
                    <button type="submit" name="delete_option">Verwijderen</button>
                    <button type="submit" name="toggle_correct"
                        style="background-color: <?= $option['is_correct'] ? 'green' : 'red' ?>; color: white; border: none; padding: 5px 10px; margin-left: 10px;">
                        <?= $option['is_correct'] ? 'Goed' : 'Fout' ?>
                    </button>
                </form>
            <?php endforeach; ?>

            <form action="" method="post">
                <input type="hidden" name="question_id" value="<?= $question['question_id'] ?>">
                <input type="text" name="option_text" placeholder="Nieuwe optie" required>
                <button type="submit" name="add_option">Toevoegen</button>
            </form>
            <hr>
            <?php
            $index++;
        endforeach;
        ?>

        <h2>Nieuwe vraag toevoegen</h2>
        <form action="" method="post">
            <input type="text" name="question_text" placeholder="Nieuwe vraag" required>
            <button type="submit" name="add_question">Toevoegen</button>
        </form>

        <a href="teacher.php">Terug</a>
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