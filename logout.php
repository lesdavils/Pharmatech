<?php
session_start();

// Détruire la session.
session_unset();
session_destroy();

// Définir le message de confirmation dans une variable de session.
session_start();
$_SESSION['logout_message'] = "Vous avez été déconnecté avec succès.";

// Rediriger vers la page d'accueil.
header("Location: index.php");
exit();
?>
