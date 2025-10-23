<?php // Démarrage de la session et inclusion des classes nécessaires
session_start(); // Démarrage de la session
require_once '../classes/Game.php'; // Inclusion de la classe Game
require_once '../classes/Card.php'; // Inclusion de la classe Card

// Récupération ou création du jeu dans la session
if (!isset($_SESSION['game'])) {
    // On choisit le nombre de paires (par défaut 4)
    $pairsCount = $_POST['pairs'] ?? 4;
    $_SESSION['game'] = new Game($pairsCount);
}

$game = $_SESSION['game']; // Récupération de l'objet Game depuis la session

// Si une carte est cliquée
if (isset($_GET['flip'])) { // Vérification si une carte a été cliquée
    $cardId = (int)$_GET['flip']; // Récupération de l'ID de la carte cliquée
    $game->flipCard($cardId); // Appel de la méthode pour retourner la carte
}

// Vérifie si le jeu est terminé
$isOver = $game->isGameOver();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Memory Game</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h1>🧠 Jeu du Memory</h1>

    <div class="score">
        <strong>Score :</strong> <?= $game->getScore(); ?>
    </div>

    <div class="grid">
        <?php foreach ($game->getCards() as $card): ?>
            <?php if ($card->isFlipped || $card->isMatched): ?>
                <div class="card flipped">
                    <img src="../assets/cartes/<?= $card->getImage(); ?>" alt="carte">
                </div>
            <?php else: ?>
                <div class="card">
                    <a href="?flip=<?= $card->getId(); ?>">
                        <img src="../assets/cartes/back.png" alt="dos de carte">
                    </a>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

    <?php if ($isOver): ?>
        <div class="game-over">
            <h2>🎉 Partie terminée !</h2>
            <p>Votre score : <?= $game->getScore(); ?></p>
            <form method="post" action="restart.php">
                <button type="submit">Rejouer</button>
            </form>
        </div>
    <?php endif; ?>
</body>
</html>
