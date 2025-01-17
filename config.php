<?php
// Database connectie

$host = '82.165.51.200';
$dbname = 's42_tijnquiz';
$username = 'u42_ZFmn4UQD3o';
$password = 'z4v=y=rmN+wBtMSk+4ZiZBbF';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>