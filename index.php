<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <header>
            <img src="img/pharmatech_logo.png" alt="Logo">
        </header>
        <?php if (isset($_SESSION['username'])): ?>
            <p>Bienvenue, <?= htmlspecialchars($_SESSION['username']) ?>!</p>
            <a href="logout.php">Déconnexion</a>
        <?php else: ?>
            <a href="login.php">Connexion</a>
            <a href="register.php">Inscription</a>
        <?php endif; ?>
    </div>
</body>
</html>
