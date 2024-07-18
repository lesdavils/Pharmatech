<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
include 'pdo.php';

$totalMedicaments = $pdo->query("SELECT COUNT(*) FROM medicaments")->fetchColumn();
$totalFabriquants = $pdo->query("SELECT COUNT(DISTINCT fabriquant) FROM medicaments")->fetchColumn();
$totalValeur = $pdo->query("SELECT SUM(prix * quantite) FROM medicaments")->fetchColumn();
$logs = $pdo->query("SELECT * FROM logs ORDER BY timestamp DESC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Médicaments</title>
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
            background-color: rgba(128, 128, 128, 0.3);
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
            background-color: rgba(255, 255, 255, 0.3);
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin: 20px;
        }

        .dashboard {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .card {
            background-color: white;
            flex: 1 1 calc(33.333% - 40px);
            min-width: 250px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-10px);
        }

        .card h3 {
            margin: 0 0 10px;
            color: #333;
        }

        .card p {
            margin: 0;
            font-size: 24px;
            color: #333;
        }

        .logs {
            margin-top: 40px;
        }

        .logs h2 {
            margin-bottom: 20px;
        }

        .logs ul {
            list-style: none;
            padding: 0;
        }

        .logs li {
            background-color: white;
            margin-bottom: 10px;
            padding: 10px 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .logs li span {
            font-weight: bold;
            color: #333;
        }

        @media (max-width: 768px) {
            .card {
                flex: 1 1 calc(50% - 40px);
            }
        }

        @media (max-width: 480px) {
            .card {
                flex: 1 1 100%;
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
    <h1>Bienvenue, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>

    <div class="dashboard">
        <div class="card">
            <h3>Nombres de médicaments</h3>
            <p><?= $totalMedicaments ?></p>
        </div>
        <div class="card">
            <h3>Nombre de fabricants différents</h3>
            <p><?= $totalFabriquants ?></p>
        </div>
        <div class="card">
            <h3>Valeur totale des médicaments</h3>
            <p><?= number_format($totalValeur, 2) ?> €</p>
        </div>
    </div>

    <div class="logs">
        <h2>Logs des activités</h2>
        <ul>
            <?php foreach ($logs as $log): ?>
                <li>
                    <span><?= htmlspecialchars($log['timestamp']) ?> - <?= htmlspecialchars($log['user']) ?>:</span> <?= htmlspecialchars($log['action']) ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

</body>
</html>
