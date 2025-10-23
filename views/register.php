<?php
session_start();
require_once '../classes/Player.php';
include_once '../config.php'; // inutile de relancer session_start()

$player = new Player();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($username && $password) {
        try {
            $player->register($username, $password);
            header('Location: login.php');
            exit;
        } catch (Exception $e) {
            $message = "Erreur : nom déjà utilisé.";
        }
    } else {
        $message = "Veuillez remplir tous les champs.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription - Memory Game</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h1>Créer un compte 🧩</h1>

    <?php if ($message): ?>
        <p class="error"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form method="post">
        <label>Nom d'utilisateur :</label><br>
        <input type="text" name="username" required><br><br>

        <label>Mot de passe :</label><br>
        <input type="password" name="password" required><br><br>

        <button type="submit">S'inscrire</button>
    </form>

    <p>Déjà inscrit ? <a href="login.php">Se connecter</a></p>
</body>
</html>
