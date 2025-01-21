<?php
    session_start();
    require 'config.php';

    if (!isset($_SESSION['user_id'])){
        header("Location: login.php");
        exit();
    }

    // Haal de scores op en sorteer ze aflopend
    $stmt = $pdo->prepare("SELECT username, points FROM users ORDER BY points DESC LIMIT 10");
    $stmt->execute();
    $scores = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scorebord</title>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/styleScores.css">
</head>
<body>
<header class="header">
    <div class="container">
        <h1 class="logo">HersenHap</h1>
        <nav>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="quizzen.php">Quizzes</a></li>
                <li><a href="scores.php">Scores</a></li>
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

<main class="main-sec">
  <div class="scoreboard">
    <h1>Scorebord</h1>
    <ul>
      <?php $rank = 1; ?>
      <?php foreach ($scores as $score): ?>
        <li>
          <div class="rank <?php echo ($rank == 1 ? 'gold' : ($rank == 2 ? 'silver' : ($rank == 3 ? 'bronze' : ''))); ?>">
            <?php echo $rank; ?>
          </div>
          <span><?php echo htmlspecialchars($score['username']); ?></span>
          <span class="score"><?php echo htmlspecialchars($score['points']); ?></span>
        </li>
        <?php $rank++; ?>
      <?php endforeach; ?>
    </ul>
  </div>
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
                <li><a href="scores.php">Scores</a></li>
            </ul>
        </div>
        <div class="footer-section">
            <h4>Contact</h4>
            <p>Email: info@hersenhap.nl</p>
            <p>Tel: 020-1234567</p>
        </div>
    </div>
    <div class="footer-bottom">
        <p>© 2025 HersenHap. Alle rechten voorbehouden.</p>
    </div>
</footer>
    
</body>
</html>
