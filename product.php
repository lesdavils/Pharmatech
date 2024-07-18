<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
include 'pdo.php';

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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $deleteId = $_POST['delete_id'];
    $deleteStmt = $pdo->prepare("DELETE FROM medicaments WHERE id = :id");
    $deleteStmt->bindParam(':id', $deleteId, PDO::PARAM_INT);
    if ($deleteStmt->execute()) {
        header("Location: product.php");
        exit();
    } else {
        echo "Erreur lors de la suppression du médicament.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Produits</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .navbar {
            background-color: #4CAF50;
            overflow: hidden;
            padding: 10px 0;
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
        .product {
            background-color: white;
            margin: 20px 0;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            display: flex;
            align-items: center;
        }
        .product:hover {
            transform: translateY(-10px);
        }
        .product img {
            max-width: 100px;
            max-height: 100px;
            border-radius: 10px;
            margin-right: 20px;
        }
        .product h2 {
            margin: 0 0 10px;
            color: #333;
        }
        .product p {
            margin: 0 0 10px;
            color: #666;
        }
        .btn-group {
            margin-top: 20px;
            display: flex;
            gap: 10px;
        }
        .btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
            text-align: center;
            flex-grow: 1;
        }
        .btn:hover {
            background-color: #45a049;
        }
        .btn-delete {
            background-color: #f44336;
        }
        .btn-delete:hover {
            background-color: #d32f2f;
        }
        @media (max-width: 768px) {
            .product {
                flex-direction: column;
                text-align: center;
            }
            .product img {
                margin-bottom: 10px;
            }
            .btn-group {
                flex-direction: column;
            }
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
    <h1>Liste des Produits</h1>

    <?php foreach ($medicaments as $medicament): ?>
    <div class="product">
        <img src="<?php echo htmlspecialchars($medicament->img); ?>" alt="Image du médicament">
        <div>
            <h2>Référence: <?php echo htmlspecialchars($medicament->reference); ?></h2>
            <p>Prix: <?php echo htmlspecialchars($medicament->prix); ?> €</p>
            <p>Dernière modification: <?php echo htmlspecialchars($medicament->derniere_modification); ?></p>
            <p>Quantité: <?php echo htmlspecialchars($medicament->quantite); ?></p>
            <p>Description: <?php echo htmlspecialchars($medicament->description); ?></p>
            <p>Fabriquant: <?php echo htmlspecialchars($medicament->fabriquant); ?></p>
            <p>Type: <?php echo htmlspecialchars($medicament->type); ?></p>
            <div class="btn-group">
                <a href="details.php?id=<?php echo htmlspecialchars($medicament->id); ?>" class="btn">Détails</a>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="delete_id" value="<?php echo htmlspecialchars($medicament->id); ?>">
                    <button type="submit" class="btn btn-delete">Supprimer</button>
                </form>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
</body>
</html>
