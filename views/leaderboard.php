<?php
session_start(); // Démarre la session utilisateur
require_once '../classes/Scoreboard.php'; // Inclut la classe Scoreboard

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user'])) { // Redirige vers la page de connexion si non connecté
    header('Location: login.php'); // Redirection vers la page de connexion
    exit;
}

$scoreboard = new Scoreboard(); // Crée une instance de Scoreboard
$top10 = $scoreboard->getTop10(); // Récupère les 10 meilleurs scores
$userScores = $scoreboard->getUserScores($_SESSION['user']['id']); // Récupère les scores de l'utilisateur connecté
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Classement - Memory Game</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h1>🏆 Classement des meilleurs joueurs</h1>

    <table class="leaderboard">
        <thead>
            <tr>
                <th>Position</th>
                <th>Joueur</th>
                <th>Meilleur Score</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($top10 as $index => $player): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= htmlspecialchars($player['username']) ?></td>
                    <td><?= $player['best_score'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2>👤 Mes derniers scores</h2>
    <table class="user-scores">
        <thead>
            <tr>
                <th>Score</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($userScores as $score): ?>
                <tr>
                    <td><?= $score['score'] ?></td>
                    <td><?= $score['played_at'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="game.php" class="btn">← Rejouer</a>
</body>
</html>