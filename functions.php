<?php

function databaseConnect()
{
    $servername = "82.165.51.200";
    $username = "u42_ZFmn4UQD3o";
    $password = "z4v=y=rmN+wBtMSk+4ZiZBbF";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=hersenhap", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connected successfully";
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}
?>