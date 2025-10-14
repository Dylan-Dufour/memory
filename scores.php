<?php // Début du code PHP
// Lecture du fichier scores
$scores = []; // Initialise un tableau vide pour stocker les scores
if (file_exists("scores.txt")) { // Vérifie si le fichier "scores.txt" existe dans le répertoire courant
    $lines = file("scores.txt", FILE_IGNORE_NEW_LINES); // Lit toutes les lignes du fichier dans un tableau, sans les sauts de ligne à la fin
    foreach ($lines as $line) { // Parcourt chaque ligne du fichier
        list($name, $score) = explode(";", $line);  // Sépare la ligne en deux parties : le nom et le score, en utilisant le point-virgule comme séparateur
        $scores[] = ["name" => $name, "score" => (int)$score]; // Ajoute une entrée au tableau $scores avec le nom et le score converti en entier
    }
}

// Trier par score croissant
usort($scores, function($a, $b) {
    return $a["score"] <=> $b["score"];
});

// Top 10
$top10 = array_slice($scores, 0, 10);

// Profil du joueur actuel
session_start();
$currentPlayer = $_SESSION["player"] ?? null; // Récupère le nom du joueur actuel depuis la session, ou null s'il n'existe pas
$playerScores = []; // Initialise un tableau vide pour stocker les scores du joueur
if ($currentPlayer) { // Vérifie si un joueur actuel a bien été défini
    foreach ($scores as $s) {  // Parcourt tous les scores disponibles dans le tableau $scores
        if ($s["name"] === $currentPlayer) { // Vérifie si le nom dans l'entrée de score correspond au joueur actuel
            $playerScores[] = $s["score"]; // Ajoute le score correspondant au tableau des scores du joueur
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Classement</title>
</head>
<body>
    <h1>Classement des 10 meilleurs joueurs</h1>
    <ol>
        <?php foreach ($top10 as $s): ?>
            <li><?php echo htmlspecialchars($s["name"]) . " - " . $s["score"] . " coups"; ?></li>   <!-- Affiche le nom du joueur (sécurisé avec htmlspecialchars) suivi de son score -->
        <?php endforeach; ?>
    </ol>

    <?php if ($currentPlayer): ?> <!-- Si une variable $currentPlayer est définie et non vide -->
        <h2> Progression de <?php echo htmlspecialchars($currentPlayer); ?></h2>
        <?php if (empty($playerScores)): ?> <!-- Si le tableau $playerScores est vide -->
            <p>Aucun score enregistré.</p> <!-- Message si aucun score n'est disponible -->
        <?php else: ?>
            <ul>
                <?php foreach ($playerScores as $sc): ?> <!-- Si le tableau $playerScores est vide -->
                    <li><?php echo $sc; ?> coups</li> <!-- Affiche le score suivi de "coups" -->
                <?php endforeach; ?>
            </ul>
            <p> Meilleur score : <?php echo min($playerScores); ?> coups</p> <!-- Affiche le meilleur score (le plus petit) du joueur -->
        <?php endif; ?>
    <?php endif; ?>

    <a href="index.php">Retour à l'accueil</a>
</body>
</html>
