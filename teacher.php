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
</head>
<body>
    <h1>Beheer mijn quizzen</h1>

    <?php if (count($quizzes) > 0): ?>
        <ul>
            <?php foreach ($quizzes as $quiz): ?>
                <li>
                    <?php echo htmlspecialchars($quiz['quiz_name']); ?>
                    <a href="editQuiz.php?quiz_id=<?php echo $quiz['quiz_id']; ?>">Bewerk</a>
                    <form action="deleteQuiz.php" method="post" style="display:inline;" onsubmit="return confirm('Weet je zeker dat je deze quiz wilt verwijderen?');">
                        <input type="hidden" name="quiz_id" value="<?php echo $quiz['quiz_id']; ?>">
                        <button type="submit">Verwijder</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Je hebt nog geen quizzen gemaakt.</p>
    <?php endif; ?>

    <a href="quiz.php">Nieuwe quiz maken</a>
</body>
</html>
