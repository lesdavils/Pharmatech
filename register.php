<?php
include 'pdo.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $email = $_POST['email'];

    $sql = 'INSERT INTO users (username, password, email) VALUES (:username, :password, :email)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['username' => $username, 'password' => $password, 'email' => $email]);

    echo 'User registered successfully';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Inscription</h2>
        <form action="register.php" method="POST">
            <label for="username">Identifiant:</label>
            <input type="text" name="username" required>
            <label for="password">Mot de passe:</label>
            <input type="password" name="password" required>
            <label for="email">E-mail:</label>
            <input type="email" name="email" required>
            <button type="submit">Inscription</button>
        </form>
        <p>Vous avez déjà un compte ? <a href="login.php">Connectez-vous</a></p>
    </div>
</body>
</html>
