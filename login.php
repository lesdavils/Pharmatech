<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($email == "admin" && $password == "admin") {
        $_SESSION['username'] = "admin";
        header("Location: accueil.php");
        exit();
    } else {
        $error_message = "Invalid login credentials.";
    }
}
?>
