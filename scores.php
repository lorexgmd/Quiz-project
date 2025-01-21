<?php
    session_start();
    require 'config.php';

    if (!isset($_SESSION['user_id'])){
        header("Location: login.php");
    }

    $stmt = $pdo->prepare("SELECT points, played_quizzes FROM users WHERE id = :user_id");
    $stmt->execute(['user_id' => $_SESSION['user_id']]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    
?>