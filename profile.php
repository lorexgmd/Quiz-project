<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php if (isset($_SESSION['user_id'])): ?>
        <?php if ($_SESSION['role'] == 'teacher'): ?>
            <a href="#">Maak quiz</a>
        <?php elseif ($_SESSION['role'] == 'student'): ?>
            <a href="#">Quiz</a>
        <?php endif; ?>
    <?php endif; ?>
</body>

</html>
