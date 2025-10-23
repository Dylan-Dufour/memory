<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/config.php';

// Rediriger si non connecté
if (empty($_SESSION['user']['id'])) {
    header('Location: login.php');
    exit;
}

// Récupère les infos utilisateur à jour depuis la base
try {
    $db = Database::getInstance();
    $stmt = $db->prepare('SELECT id, username, bestScore FROM users WHERE id = ?');
    $stmt->execute([$_SESSION['user']['id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC) ?: $_SESSION['user'];
} catch (Exception $e) {
    // En cas d'erreur DB on utilise la session
    $user = $_SESSION['user'];
}

// Échappement simple pour l'affichage
function e($str) {
    return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Tableau de bord - <?= e($user['username']) ?></title>
</head>
<body>
    <h1>Bonjour, <?= e($user['username']) ?></h1>
    <p>Meilleur score : <strong><?= e($user['bestScore'] ?? 0) ?></strong></p>

    <ul>
        <li><a href="game.php">Jouer</a></li>
        <li><a href="profil.php">Mon profil</a></li>
        <li><a href="controller.php?action=logout">Se déconnecter</a></li>
    </ul>

    <!-- Optionnel : zone messages flash -->
    <?php if (!empty($_SESSION['flash'])): ?>
        <p><?= e($_SESSION['flash']) ?></p>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>
</body>
</html>
?>