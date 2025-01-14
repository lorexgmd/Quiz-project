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
    <h3>Naam: <?php if (isset($_SESSION['user_id'])){
        echo $_SESSION['username'];
    
    }
    ?></h3>
</body>
</html>