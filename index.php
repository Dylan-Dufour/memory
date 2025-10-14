<?php
require_once "Card.php";
require_once "Player.php";
require_once "Game.php";

// --- Initialisation du jeu ---
$nombrePaires = 5;
$game = new Game("Dylan", $nombrePaires);

// --- Création des joueurs ---
$player1 = new Player("Dylan");
$player1->addScore(20);
$player1->addScore(15);

$player2 = new Player("Alice");
$player2->addScore(12);

// --- Ajout des joueurs à la partie ---
$game->addPlayer($player1);
$game->addPlayer($player2);

// --- Affichage des cartes en jeu ---

echo "<h3>Cartes en jeu :</h3>";
$cards = $game->getCards(6);
foreach ($cards as $card) {
    // Si $card est un objet Card
    if (is_object($card) && method_exists($card, 'getImage')) {
        echo "[" . $card->getImage() . "]";
    } else {
        // Sinon, affiche la valeur brute (ex: une lettre)
        echo "[" . $card . "]";
    }
}
require_once 'game.php';

$game = new Game("Dylan");

$cards = $game->getCards(6); //  Ici on passe 6 paires, soit 12 cartes
echo "<br>";

// --- Affichage du classement ---
echo "<h3>Classement :</h3>";
foreach ($game->getRanking() as $rank) {
    echo $rank["player"] . " - Score: " . $rank["bestScore"] . "<br>";
}
require_once 'game.php';

$game = new Game();

// Si formulaire soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $player = trim($_POST['player'] ?? '');
    $score = intval($_POST['score'] ?? 0);

    if (!empty($player) && $score > 0) {
        $game->addToRanking($player, $score);
    }
}

// Récupération du classement
$ranking = $game->getRanking();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Classement Memory</title>
</head>
<body>
    <h1>🏆 Classement du Jeu</h1>

    <!-- Formulaire pour ajouter un score -->
    <form method="post" action="">
        <label>Nom du joueur :
            <input type="text" name="player" required>
        </label><br><br>
        <label>Score :
            <input type="number" name="score" required min="1">
        </label><br><br>
        <input type="submit" value="Ajouter au classement">
    </form>

    <h2>📋 Classement actuel :</h2>
    <?php if (count($ranking) > 0): ?>
        <ol>
            <?php foreach ($ranking as $entry): ?>
                
                <li>
                    <?= htmlspecialchars($entry['player']) ?> : 
                    <?= $entry['score'] ?> points 
                    (<?= $entry['date'] ?>)
                </li>
            <?php endforeach; ?>
        </ol>
    <?php else: ?>
        <p>Aucun score enregistré pour le moment.</p>
    <?php endif; ?>
</body>
</html>


// --- Affichage des scores individuels ---
echo "<h3>Scores de Dylan :</h3>";
foreach ($player1->getAllScores() as $score) {
    echo $score . " coups<br>";
}
require_once 'game.php'; // Inclut la classe

$game = new Game();             // ✅ Instanciation correcte
$cards = $game->getCards(6);    // ✅ Appel de la méthode avec un argument

// Affichage simple
echo "<pre>";
print_r($cards);
echo "</pre>";
