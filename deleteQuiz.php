<?php
session_start();

// Connect de database in deze file
require 'config.php';

// Checkt of je bent ingelogd
if (!isset($_SESSION['user_id'])) {
    die("Je moet ingelogd zijn om een quiz te verwijderen.");
}

$user_id = $_SESSION['user_id'];

// verwijderd de quiz die is aangegeven in de post
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $quiz_id = $_POST['quiz_id'];

    $stmt = $pdo->prepare("SELECT * FROM Quiz WHERE quiz_id = :quiz_id AND created_by = :user_id");
    $stmt->execute(['quiz_id' => $quiz_id, 'user_id' => $user_id]);
    $quiz = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$quiz) {
        die("Quiz niet gevonden of je hebt geen rechten om deze te verwijderen.");
    }

    $pdo->prepare("DELETE FROM Options WHERE question_id IN (SELECT question_id FROM Questions WHERE quiz_id = :quiz_id)")->execute(['quiz_id' => $quiz_id]);
    $pdo->prepare("DELETE FROM Questions WHERE quiz_id = :quiz_id")->execute(['quiz_id' => $quiz_id]);
    $pdo->prepare("DELETE FROM Quiz WHERE quiz_id = :quiz_id")->execute(['quiz_id' => $quiz_id]);

    echo "Quiz succesvol verwijderd!";
    header("Location: teacher.php");
    exit;
}
?>
