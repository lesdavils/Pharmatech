<?php

include 'config.php';

// Vérifier si l'ID du médicament est passé en paramètre
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "ID du médicament non spécifié.";
    exit();
}

// Récupérer l'ID du médicament depuis $_GET
$id = $_GET['id'];

try {
    // Requête SQL pour récupérer les détails du médicament spécifié par l'ID
    $sql = "SELECT * FROM medicaments WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() == 1) {
        $medicament = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        echo "Médicament non trouvé.";
        exit();
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
    <title>Détails du médicament</title>
    <style>
        /* Styles CSS précédemment définis */
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
        .details-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .details-container h2 {
            margin-bottom: 20px;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .details-table th, .details-table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .details-table th {
            background-color: #f2f2f2;
        }
        .btn-group {
            margin-top: 20px;
            text-align: right;
        }
        .btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #45a049;
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
    <div class="details-container">
        <h2>Détails du médicament</h2>
        
        <table class="details-table">
            <tr>
                <th>ID</th>
                <td><?php echo htmlspecialchars($medicament['id']); ?></td>
            </tr>
            <tr>
                <th>Référence</th>
                <td><?php echo htmlspecialchars($medicament['reference']); ?></td>
            </tr>
            <tr>
                <th>Prix</th>
                <td><?php echo htmlspecialchars($medicament['prix']); ?> €</td>
            </tr>
            <tr>
                <th>Dernière modification</th>
                <td><?php echo htmlspecialchars($medicament['derniere_modification']); ?></td>
            </tr>
            <tr>
                <th>Quantité</th>
                <td><?php echo htmlspecialchars($medicament['quantite']); ?></td>
            </tr>
            <tr>
                <th>Description</th>
                <td><?php echo htmlspecialchars($medicament['description']); ?></td>
            </tr>
            <tr>
                <th>Fabricant</th>
                <td><?php echo htmlspecialchars($medicament['fabriquant']); ?></td>
            </tr>
            <tr>
                <th>Type</th>
                <td><?php echo htmlspecialchars($medicament['type']); ?></td>
            </tr>
        </table>

        <div class="btn-group">
            <a href="edit.php?id=<?php echo $id; ?>" class="btn">Modifier</a>
            <a href="product.php" class="btn" style="background-color: #008CBA;">Retour</a>
        </div>
    </div>
</div>

</body>
</html>
