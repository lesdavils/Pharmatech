<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($email == "admin@pharmatech.com" && $password == "admin") {
        $_SESSION['username'] = "admin";
        header("Location: accueil.php");
        exit();
    } else {
        $_SESSION['error_message'] = "L'email ou le mot de passe est incorrect.";
        header("Location: index.php");
        exit();
    }
}
?>
