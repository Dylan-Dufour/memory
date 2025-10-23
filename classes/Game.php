<?php

include_once(__DIR__ . '/../config.php');

class Game {
    private $db;
    private $cards; // Tableau des cartes
    private $score; // Score du joueur
    private $pairsCount; // Nombre de paires dans le jeu
    private $flippedCards; // Cartes actuellement retournées

    public function __construct($database) { // Injection de dépendance
        $this->db = $database; // Instance de Database
        $this->pairsCount = $pairsCount; // Nombre de paires dans le jeu
        $this->score = 0;
        $this->cards = []; // Tableau des cartes
        $this->flippedCards = [];
        $this->generateCards(); // Génère les cartes du jeu
    }

    //private function generateCards() {
        // Logique pour choisir aléatoirement $pairsCount images
        // et créer deux cartes identiques pour chaque image
        // puis mélanger le tout
    //}
    //public function flipCard($cardId) {
        // Trouve la carte par son ID
        // Si elle n'est ni retournée ni déjà trouvée, on la retourne
        // Et on l'ajoute dans $flippedCards
    //}
    public function checkForMatch() {
        [$a, $b] = $this->flipped;
        if ($this->cards[$a]->image === $this->cards[$b]->image) {
            $this->cards[$a]->isMatched = $this->cards[$b]->isMatched = true;
            $this->score += 10;
        } else {
            $this->cards[$a]->isFlipped = $this->cards[$b]->isFlipped = false;
            $this->score -= 2;
        }
        // Vérifie si les deux cartes retournées sont identiques
        // Si oui, incrémente le score et vide $flippedCards
        // Sinon, retourne les cartes et vide $flippedCards
    }
    public function isGameOver() {
        foreach ($this->cards as $card) if (!$card->isMatched) return false;
        return true;
        
        // Vérifie si toutes les paires ont été trouvées
    }

public function initializeGame($pairsCount) { // Initialisation du jeu avec le nombre de paires
        $this->pairsCount = $pairsCount; // Nombre de paires dans le jeu
        $this->score = 0;
        $this->flippedCards = []; // Cartes actuellement retournées
        //$this->generateCards(); // Génère les cartes du jeu
    }

    private function generateCards() { // Génère les cartes du jeu
        $this->cards = []; // Réinitialise le tableau des cartes
        for ($i = 1; $i <= $this->pairsCount; $i++) {
            $this->cards[] = ['id' => $i, 'flipped' => false]; // Première carte de la paire
            $this->cards[] = ['id' => $i, 'flipped' => false]; // Deuxième carte de la paire
        }
        shuffle($this->cards);
    }
    public function flipCard($cardIndex) { // Retourne une carte
        if (isset($this->cards[$cardIndex]) && !$this->cards[$cardIndex]['flipped']) { // Si la carte existe et n'est pas déjà retournée
            $this->cards[$cardIndex]['flipped'] = true; // Retourne la carte
            $this->flippedCards[] = $cardIndex; // Ajoute la carte aux cartes retournées
        }
    }
    public function getScore() { return $this->score; }
    public function getCards() { return $this->cards; }
}
