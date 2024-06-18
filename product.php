<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

class Medicament {
    public $nom;
    public $dose;
    public $forme;
    public $fabricant;
    public $date_expiration;

    public function __construct($nom, $dose, $forme, $fabricant, $date_expiration) {
        $this->nom = $nom;
        $this->dose = $dose;
        $this->forme = $forme;
        $this->fabricant = $fabricant;
        $this->date_expiration = $date_expiration;
    }
}

$medicaments = [
    new Medicament("Paracétamol", "500mg", "Comprimé", "Sanofi", "2024-12-31"),
    new Medicament("Ibuprofène", "200mg", "Capsule", "Pfizer", "2025-06-30"),
    new Medicament("Amoxicilline", "250mg", "Sirop", "GSK", "2023-09-15"),
    new Medicament("Aspirine", "100mg", "Comprimé", "Bayer", "2024-05-20"),
    new Medicament("Oméprazole", "20mg", "Gélule", "AstraZeneca", "2025-11-10"),
];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'accueil - Médicaments</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .navbar {
            background-color: #4CAF50;
            overflow: hidden;
        }
        .navbar a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
        }
        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }
        .container {
            padding: 20px;
        }
        .product-card {
            background-color: white;
            margin: 20px 0;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .product-card h2 {
            margin: 0 0 10px;
        }
        .product-card p {
            margin: 0 0 20px;
        }
        .product-card .btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .product-card .btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<div class="navbar">
    <a href="accueil.php">Accueil</a>
    <a href="commandes.php">Produits</a>
    <a href="deconnexion.php">Déconnexion</a>
</div>

<div class="container">
    <h1>Bonjour, <?php echo htmlspecialchars($_SESSION['username']); ?>! Voici les médicaments</h1>

    <?php foreach ($medicaments as $medicament): ?>
    <div class="product-card">
        <!-- Affichage du nom du médicament -->
        <h2><?php echo htmlspecialchars($medicament->nom); ?></h2>
        <!-- Affichage de la dose du médicament -->
        <p>Dose: <?php echo htmlspecialchars($medicament->dose); ?></p>
        <!-- Affichage de la forme du médicament (par exemple, comprimé, capsule, etc.) -->
        <p>Forme: <?php echo htmlspecialchars($medicament->forme); ?></p>
        <!-- Affichage du fabricant du médicament -->
        <p>Fabricant: <?php echo htmlspecialchars($medicament->fabricant); ?></p>
        <!-- Affichage de la date d'expiration du médicament -->
        <p>Date d'expiration: <?php echo htmlspecialchars($medicament->date_expiration); ?></p>
        <!-- Bouton pour acheter le médicament (actuellement sans lien actif) -->
        <a href="#" class="btn">Acheter maintenant</a>
    </div>
    <?php endforeach; ?>
</div>

</body>
</html>
