<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'pdo.php';

// Vérifier si le formulaire a été soumis pour ajouter un nouveau produit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reference = htmlspecialchars($_POST['reference']);
    $prix = htmlspecialchars($_POST['prix']);
    $quantite = htmlspecialchars($_POST['quantite']);
    $description = htmlspecialchars($_POST['description']);
    $fabriquant = htmlspecialchars($_POST['fabriquant']);
    $type = htmlspecialchars($_POST['type']);
    $img = htmlspecialchars($_POST['img']);

    try {
        $sql = "INSERT INTO medicaments (reference, prix, quantite, description, fabriquant, type, img) VALUES (:reference, :prix, :quantite, :description, :fabriquant, :type, :img)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'reference' => $reference,
            'prix' => $prix,
            'quantite' => $quantite,
            'description' => $description,
            'fabriquant' => $fabriquant,
            'type' => $type,
            'img' => $img
        ]);
        // Ajouter une entrée dans les logs
        $logSql = "INSERT INTO logs (user, action) VALUES (:user, :action)";
        $logStmt = $pdo->prepare($logSql);
        $logStmt->execute([
            'user' => $_SESSION['username'],
            'action' => "Ajout du médicament $reference"
        ]);
        // Rediriger vers la page des produits après l'ajout
        header("Location: product.php");
        exit();
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
    <title>Ajouter un médicament</title>
    <style>
     <style>
        @font-face {
        font-family: 'Marianne';
        src: url('fonts/marianne/Marianne-Regular.woff2') format('woff2'),
         url('fonts/marianne/Marianne-Regular.woff') format('woff');
        font-weight: 400;
        font-style: normal;
        }
        @font-face {
        font-family: 'Marianne';
        src: url('fonts/marianne/Marianne-Bold.woff2') format('woff2'),
         url('fonts/marianne/Marianne-Bold.woff') format('woff');
        font-weight: 700;
        font-style: normal;
        }
        body {
            font-family: 'Marianne', sans-serif;
            margin: 0;
            padding: 0;
            background: url('img/background.jpg') no-repeat center center fixed;
            background-size: cover;
        }
        .navbar {
            background-color: rgba(128, 128, 128, 0.3); /* gris avec transparence */
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
        .form-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: rgba(255, 255, 255, 0.3);
            padding: 20px;
            border-radius: 20px;
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
            background-color: rgba(128, 128, 128, 0.5);
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: rgba(128, 128, 128, 0.9);
        }
    </style>   
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
        <h2>Ajouter un médicament</h2>
        
        <form action="" method="post">
            <div class="form-group">
                <label for="reference">Référence</label>
                <input type="text" id="reference" name="reference" required>
            </div>
            <div class="form-group">
                <label for="prix">Prix</label>
                <input type="number" id="prix" name="prix" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="quantite">Quantité</label>
                <input type="number" id="quantite" name="quantite" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="fabriquant">Fabriquant</label>
                <input type="text" id="fabriquant" name="fabriquant" required>
            </div>
            <div class="form-group">
                <label for="type">Type</label>
                <input type="text" id="type" name="type" required>
            </div>
            <div class="form-group">
                <label for="img">URL de l'image</label>
                <input type="text" id="img" name="img" required>
            </div>
            <div class="btn-group">
                <button type="submit" class="btn">Ajouter</button>
                <a href="product.php" class="btn" style="background-color: #008CBA;">Annuler</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>
