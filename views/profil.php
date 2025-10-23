<?php
session_start();
require_once '../classes/Scoreboard.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$scoreboard = new Scoreboard();
$user = $_SESSION['user'];
$userScores = $scoreboard->getUserScores($user['id']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Profil - Memory Game</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h1>👤 Profil de <?= htmlspecialchars($user['username']) ?></h1>

    <h2>Mes 5 meilleurs scores</h2>
    <table class="user-scores">
        <thead>
            <tr>
                <th>Score</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($userScores): ?>
                <?php foreach ($userScores as $score): ?>
                    <tr>
                        <td><?= $score['score'] ?></td>
                        <td><?= $score['played_at'] ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="2">Aucun score enregistré pour le moment.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <a href="game.php" class="btn">🎮 Jouer</a> |
    <a href="leaderboard.php" class="btn">🏆 Classement</a> |
    <a href="../logout.php" class="btn">🚪 Déconnexion</a>
</body>
</html>