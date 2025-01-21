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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
      <li>
        <div class="rank gold">1</div> <span>test1</span> <span class="score">980</span>
      </li>
      <li>
        <div class="rank silver">2</div> <span>test2</span> <span class="score">875</span>
      </li>
      <li>
        <div class="rank bronze">3</div> <span>test3</span> <span class="score">820</span>
      </li>
      <li>
        <div class="rank">4</div> <span>test4</span> <span class="score">780</span>
      </li>
      <li>
        <div class="rank">5</div> <span>test5</span> <span class="score">755</span>
      </li>
      <li>
        <div class="rank">6</div> <span>test6</span> <span class="score">720</span>
      </li>
      <li>
        <div class="rank">7</div> <span>test7</span> <span class="score">690</span>
      </li>
      <li>
        <div class="rank">8</div> <span>test8</span> <span class="score">650</span>
      </li>
      <li>
        <div class="rank">9</div> <span>test9</span> <span class="score">620</span>
      </li>
      <li>
        <div class="rank">10</div> <span>test10</span> <span class="score">590</span>
      </li>
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