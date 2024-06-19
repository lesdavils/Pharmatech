<?php
$host = 'localhost';  // Adresse du serveur MySQL
$db = 'pharmatech';   // Nom de la base de données
$user = 'root';       // Nom d'utilisateur MySQL
$pass = '';           // Mot de passe MySQL

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    // Définit le mode d'erreur de PDO pour lancer des exceptions
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>
