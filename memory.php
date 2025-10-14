<?php
session_start();

// Création des cartes si ce n'est pas déjà fait
if (!isset($_SESSION['cards'])) {
    // Exemple avec 4 paires (A, B, C, D)
    $pairs = ['A', 'B', 'C', 'D'];
    $cards = array_merge($pairs, $pairs); // Deux fois chaque carte
    shuffle($cards); // Mélanger les cartes

    $_SESSION['cards'] = $cards;
    $_SESSION['revealed'] = array_fill(0, count($cards), false); // Toutes les cartes cachées
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cardIndex'])) {
    $i = intval($_POST['cardIndex']);
    $_SESSION['revealed'][$i] = true;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Jeu de Memory</title>
    <style>
        .grid {
            display: grid;
            grid-template-columns: repeat(4, 100px);
            gap: 10px;
        }
        .card {
            width: 100px;
            height: 100px;
            background-color: #007BFF;
            color: white;
            font-size: 2em;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
        }
        .hidden {
            background-color: #ccc;
            color: transparent;
        }
    </style>
</head>
<body>

<h1>Jeu de Memory</h1>

<div class="grid">
    <?php
    foreach ($_SESSION['cards'] as $index => $card) {
        $isRevealed = $_SESSION['revealed'][$index];
        echo '<form method="post" style="margin:0;">';
        echo '<input type="hidden" name="cardIndex" value="' . $index . '">';
        echo '<button class="card ' . ($isRevealed ? '' : 'hidden') . '" type="submit">';
        echo $card;
        echo '</button>';
        echo '</form>';
    }
    ?>
</div>
</body>
</html>
