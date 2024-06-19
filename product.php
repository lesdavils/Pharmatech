<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

// Inclure le fichier de configuration pour établir la connexion à la base de données
include 'config.php';

class Medicament {
    public $id;
    public $reference;
    public $prix;
    public $derniere_modification;
    public $quantite;
    public $description;
    public $fabriquant;
    public $img;
    public $type;

    public function __construct($id, $reference, $prix, $derniere_modification, $quantite, $description, $fabriquant, $img, $type) {
        $this->id = $id;
        $this->reference = $reference;
        $this->prix = $prix;
        $this->derniere_modification = $derniere_modification;
        $this->quantite = $quantite;
        $this->description = $description;
        $this->fabriquant = $fabriquant;
        $this->img = $img;
        $this->type = $type;
    }
}

try {
    // Requête SQL pour sélectionner tous les médicaments
    $sql = "SELECT * FROM medicaments";
    $stmt = $pdo->query($sql);

    // Vérifie si des résultats ont été retournés
    if ($stmt->rowCount() > 0) {
        // Récupère tous les résultats dans un tableau d'objets Medicament
        $medicaments = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $medicaments[] = new Medicament(
                $row['id'],
                $row['reference'],
                $row['prix'],
                $row['derniere_modification'],
                $row['quantite'],
                $row['description'],
                $row['fabriquant'],
                $row['img'],
                $row['type']
            );
        }
    } else {
        $medicaments = [];
    }
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
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
        .product-card img {
            max-width: 100px;
            max-height: 100px;
            display: block;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="navbar">
    <a href="accueil.php">Accueil</a>
    <a href="product.php">Produits</a>
    <a href="logout.php">Déconnexion</a>
</div>

<div class="container">
    <h1>Bonjour, <?php echo htmlspecialchars($_SESSION['username']); ?>! Voici les médicaments disponibles </h1>

    <?php foreach ($medicaments as $medicament): ?>
    <div class="product-card">
        <img src="<?php echo htmlspecialchars($medicament->img); ?>" alt="Image du médicament">
        <h2>Référence: <?php echo htmlspecialchars($medicament->reference); ?></h2>
        <p>Prix: <?php echo htmlspecialchars($medicament->prix); ?> €</p>
        <p>Dernière modification: <?php echo htmlspecialchars($medicament->derniere_modification); ?></p>
        <p>Quantité: <?php echo htmlspecialchars($medicament->quantite); ?></p>
        <p>Description: <?php echo htmlspecialchars($medicament->description); ?></p>
        <p>Fabriquant: <?php echo htmlspecialchars($medicament->fabriquant); ?></p>
        <p>Type: <?php echo htmlspecialchars($medicament->type); ?></p>
        <a href="#" class="btn">Acheter maintenant</a>
    </div>
    <?php endforeach; ?>
</div>

</body>
</html>
