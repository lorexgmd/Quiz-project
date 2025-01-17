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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $quiz_name = $_POST['quiz_name'];

    $stmt = $pdo->prepare("UPDATE Quiz SET quiz_name = :quiz_name WHERE quiz_id = :quiz_id AND created_by = :user_id");
    $stmt->execute(['quiz_name' => $quiz_name, 'quiz_id' => $quiz_id, 'user_id' => $user_id]);

    echo "Quiz succesvol bijgewerkt!";
    header("Location: teacher.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quiz bewerken</title>
</head>
<body>
    <h1>Quiz bewerken</h1>
    <form action="" method="post">
        <label for="quiz_name">Quiznaam:</label>
        <input type="text" name="quiz_name" id="quiz_name" value="<?php echo htmlspecialchars($quiz['quiz_name']); ?>" required>
        <button type="submit">Opslaan</button>
    </form>
    <a href="manageQuiz.php">Terug</a>
</body>
</html>
