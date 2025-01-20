<?php
    session_start();
    require 'config.php';

    if (!isset($_SESSION['user_id'])){
        header("Location: login.php");
    }
?>