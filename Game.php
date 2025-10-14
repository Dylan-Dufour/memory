<?php // Début du code PHP
session_start();
require_once "Card.php"; // Vérifie bien la majuscule
class Game {
    // Propriétés
    private $name; // nom du joueur
    private $maxPlayers; // le nombre maximum de joueurs
    private $players = []; // joueurs
    private $isRunning = false;

    // Constructeur : appelé lors de la création d'une instance
    public function __construct($name = "Dylan", $maxPlayers = 2) {
        $this->name = $name;
        $this->maxPlayers = $maxPlayers;
    }

    // Méthode pour ajouter un joueur
    public function addPlayer($playerName) {
        if (count($this->players) < $this->maxPlayers) {
            $this->players[] = $playerName;
            echo "{$playerName->getName()} a rejoint la partie.\n";
        } else {
            echo "La partie est pleine.\n";
        }
    }

    // Méthode pour démarrer le jeu
    public function start() {
        if (count($this->players) > 0) {
            $this->isRunning = true;
            echo "Le jeu {$this->name} a démarré !\n";
        } else {
            echo "Impossible de démarrer : aucun joueur inscrit.\n";
        }
    }

    // Méthode pour terminer le jeu
    public function end() {
        $this->isRunning = false;
        echo "Le jeu {$this->name} est terminé.\n";
    }

    // Méthode pour afficher l'état du jeu
    public function status() {
        $status = $this->isRunning ? "en cours" : "arrêté";
        echo "Le jeu {$this->name} est $status.\n";
    }
    // Méthode pour ajouter des cartes


public function getCards(int $nbPaires): array {
    $cards = [];

    // Générer les paires (A, B, C, etc. ou 1, 2, 3...)
    for ($i = 0; $i < $nbPaires; $i++) {
        $cardValue = chr(65 + $i); // 65 = A, 66 = B, etc.
        $cards[] = $cardValue;
        $cards[] = $cardValue;
    }

    shuffle($cards);
    return $cards;
}
// Méthode pour ajouter le rank
public function getRanking(){
// Exemple de données en dur (à remplacer par une vraie source de données)
    return [
        ["player" => "Alice", "bestScore" => 12,"score"=>10,"date"=>"13-10-2025"],
        ["player" => "Dylan", "bestScore" => 15,"score"=>10,"date"=>"12-10-2025"],
        ["player" => "Bob", "bestScore" => 18,"score"=>10,"date"=>"11-10-2025"],
    ];
}
}


// Récupération du pseudo + paires
$playerName = $_GET["player"] ?? $_SESSION["player"] ?? "Anonyme";
$pairs = isset($_GET["pairs"]) ? (int) $_GET["pairs"] : ($_SESSION["pairs"] ?? 3); 
if ($pairs < 3) $pairs = 3; 
if ($pairs > 12) $pairs = 12;

$_SESSION["player"] = $playerName;
$_SESSION["pairs"] = $pairs;




// Initialisation du jeu
if (!isset($_SESSION["cards"])) {
    $allImages = glob("cartes/*.png"); // Récupère toutes les cartes
$allImages = array_diff($allImages, ["cartes/back.png"]); // enlève le dos

    shuffle($allImages); // Mélange

    $cards = [];  // Initialise un tableau vide pour stocker les cartes du jeu

    for ($i = 0; $i < $pairs; $i++) {  // Boucle pour créer les paires de cartes (une paire par itération)
        $image = $allImages[$i];  // Récupère une image différente pour chaque paire depuis le tableau $allImages
        $cards[] = new Card($i*2, $image); // Crée la première carte de la paire avec un ID pair, et l'ajoute au tableau
        $cards[] = new Card($i*2+1, $image); // Crée la deuxième carte de la paire avec un ID impair, et l'ajoute aussi
    }

    shuffle($cards); // Mélange les cartes de manière aléatoire pour le jeu
    $_SESSION["cards"] = $cards; // Stocke le tableau de cartes mélangées dans la session (pour le garder entre les pages)
    $_SESSION["flipped"] = [];  // Initialise un tableau vide pour garder en mémoire les cartes retournées
    $_SESSION["moves"] = 0;  // Initialise le compteur de coups à 0 (nombre de paires tentées)

}

$cards = $_SESSION["cards"];  // Recharge les cartes depuis la session dans une variable locale pour une utilisation directe
