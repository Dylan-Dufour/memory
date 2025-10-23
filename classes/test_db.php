<?php // test_db.php
require_once 'Database.php'; // Inclure la classe Database

$db = new Database(); // Créer une instance de la classe Database
$conn = $db->connect(); // Tenter de se connecter à la base de données

if ($conn) { // Vérifier si la connexion a réussi
    echo "Connexion réussie à la base de données !"; // Afficher un message de succès
}
?>
