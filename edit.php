<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

include 'config.php';

// Vérifier si l'ID du médicament est passé en paramètre
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "ID du médicament non spécifié.";
    exit();
}

// Récupérer l'ID du médicament depuis $_GET
$id = $_GET['id'];

// Initialiser les variables pour pré-remplir le formulaire
$reference = '';
$prix = '';
$quantite = '';
$description = '';
$fabriquant = '';
$type = '';

// Vérifier si le formulaire a été soumis pour mettre à jour les données
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Valider et récupérer les données du formulaire
    $reference = htmlspecialchars($_POST['reference']);
    $prix = htmlspecialchars($_POST['prix']);
    $quantite = htmlspecialchars($_POST['quantite']);
    $description = htmlspecialchars($_POST['description']);
    $fabriquant = htmlspecialchars($_POST['fabriquant']);
    $type = htmlspecialchars($_POST['type']);

    // Validation minimale des données (vous pouvez ajouter d'autres validations ici)

    // Mettre à jour les données dans la base de données
    try {
        $sql = "UPDATE `medicaments` SET `id`= :id,`reference`= :reference,`prix`= :prix,`quantite`= :quantite,`description`= :description,`fabriquant`= :fabriquant,`type`= :type WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $id, 'reference' => $reference, 'prix' => $prix, 'quantite' => $quantite, 'description' => $description, 'fabriquant' => $fabriquant, 'type' => $type]);

        // Rediriger vers la page de détails après la mise à jour
        header("Location: details.php?id=$id");
        exit();
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
} else {
    // Récupérer les données actuelles du médicament depuis la base de données pour pré-remplir le formulaire
    try {
        $sql = "SELECT * FROM medicaments WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $medicament = $stmt->fetch(PDO::FETCH_ASSOC);
            $reference = $medicament['reference'];
            $prix = $medicament['prix'];
            $quantite = $medicament['quantite'];
            $description = $medicament['description'];
            $fabriquant = $medicament['fabriquant'];
            $type = $medicament['type'];
        } else {
            echo "Médicament non trouvé.";
            exit();
        }
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un médicament</title>
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
        .form-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-container h2 {
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input, .form-group textarea {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
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
    <div class="form-container">
        <h2>Modifier un médicament</h2>
        
        <form action="" method="post">
            <div class="form-group">
                <label for="reference">Référence</label>
                <input type="text" id="reference" name="reference" value="<?php echo htmlspecialchars($reference); ?>" required>
            </div>
            <div class="form-group">
                <label for="prix">Prix</label>
                <input type="number" id="prix" name="prix" value="<?php echo htmlspecialchars($prix); ?>" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="quantite">Quantité</label>
                <input type="number" id="quantite" name="quantite" value="<?php echo htmlspecialchars($quantite); ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="4" required><?php echo htmlspecialchars($description); ?></textarea>
            </div>
            <div class="form-group">
                <label for="fabriquant">Fabriquant</label>
                <input type="text" id="fabriquant" name="fabriquant" value="<?php echo htmlspecialchars($fabriquant); ?>" required>
            </div>
            <div class="form-group">
                <label for="type">Type</label>
                <input type="text" id="type" name="type" value="<?php echo htmlspecialchars($type); ?>" required>
            </div>
            <div class="btn-group">
                <button type="submit" class="btn">Enregistrer les modifications</button>
                <a href="details.php?id=<?php echo $id; ?>" class="btn" style="background-color: #008CBA;">Annuler</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>
