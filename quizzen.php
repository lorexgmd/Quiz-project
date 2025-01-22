<?php
session_start();
require 'config.php';

function getQuizzes($page = 1, $limit = 3) {
    global $pdo;
    
    // Bereken de offset voor de pagina
    $offset = ($page - 1) * $limit;
    
    // Haal de quizzen op voor de huidige pagina
    $stmt = $pdo->prepare("SELECT * FROM Quiz LIMIT :limit OFFSET :offset");
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getTotalPages($limit = 3) {
    global $pdo;
    $stmt = $pdo->query("SELECT COUNT(*) FROM Quiz");
    $totalQuizzes = $stmt->fetchColumn();
    
    return ceil($totalQuizzes / $limit); // Ronde af naar boven om het totaal aantal pagina's te krijgen
}

// Haal de huidige pagina op (standaard is pagina 1)
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

$quizzes = getQuizzes($page);
$totalPages = getTotalPages();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quizzes</title>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/styleQuiz.css">
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

<main class="main">
    <div class="search-bar">
        <input type="text" placeholder="Zoek een quiz...">
        <button class="btn">Zoeken</button>
    </div>
    
    <div class="quiz-list">
        <?php foreach ($quizzes as $quiz): ?>
            <div class="quiz-item">
                <h3><?php echo htmlspecialchars($quiz['quiz_name']); ?></h3>
                <p><?php echo htmlspecialchars($quiz['description']); ?></p>
                <form action="playQuiz.php" method="get">
                    <input type="hidden" name="quiz_id" value="<?php echo $quiz['quiz_id']; ?>">
                    <button class="btn start" type="submit">Start</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
    
    <!-- Paginering -->
    <div class="pagination">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?page=<?php echo $i; ?>" class="page <?php echo $i == $page ? 'active' : ''; ?>">
                <?php echo $i; ?>
            </a>
        <?php endfor; ?>
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
            <p>Email: info@quizapp.nl</p>
            <p>Tel: 020-1234567</p>
        </div>
    </div>
    <div class="footer-bottom">
        <p>© 2025 HersenHap. Alle rechten voorbehouden.</p>
    </div>
</footer>

<script src="js/javascript.js"></script>
</body>
</html>
