<?php // Début du code PHP
include_once(__DIR__ . '/../config.php'); // Inclusion du fichier de configuration
class Card { // Définition de la classe Card
    public $id;   // Identifiant unique de la carte
    public $isFlipped; // Indique si la carte est retournée
    public $isMatched; // Indique si la carte a été appariée
    public $image; // Image associée à la carte
    private $db; // Instance de la base de données
public function __construct($id, $image, $db) { // Constructeur de la classe
    $this->db = $db; // Initialisation de l'instance de la base de données
    $this->id = $id; // Initialisation de l'identifiant
    $this->image = $image; // Initialisation de l'image
    $this->isFlipped = false;   // Initialisation de l'état retourné
    $this->isMatched = false;
}
public function flip() {   // Méthode pour retourner la carte
    $this->isFlipped = !$this->isFlipped; // Inversion de l'état retourné
    $this->db->updateCard($this); // Mise à jour de la carte dans la base de données
}
public function markAsMatched() {   // Méthode pour marquer la carte comme appariée
    $this->isMatched = true; // Marquer la carte comme appariée
    $this->db->updateCard($this); // Mise à jour de la carte dans la base de données
}
public function reset() {   // Méthode pour réinitialiser la carte
    $this->isFlipped = false; // Réinitialiser l'état retourné
    $this->isMatched = false; // Réinitialiser l'état apparié
    $this->db->updateCard($this); // Mise à jour de la carte dans la base de données
}
public function match(Card $otherCard) {  // Méthode pour vérifier si deux cartes correspondent
    if ($this->image === $otherCard->image) { // Vérification de la correspondance des images
        $this->isMatched = true; // Marquer les deux cartes comme appariées
        $otherCard->isMatched = true; // Marquer les deux cartes comme appariées
        return true;
    }
    return false;
}
}
