<?php // Début du code PHP
//Player.php
class Player {
    private $name;       // Nom du joueur
    private $scores = []; // Tableau des scores du joueur

    public function __construct($name) {  // Constructeur de la classe, appelé automatiquement à la création d'un objet
        $this->name = $name;  // Initialise la propriété "name" avec la valeur passée en paramètre
    }

    public function getName() { // Méthode publique permettant d'accéder à la propriété "name"
        return $this->name; // Retourne la valeur de la propriété "name"
    }

    public function addScore($score) {
        $this->scores[] = $score; // Ajoute un score au profil
    }

    public function getBestScore() { // Méthode publique qui retourne le meilleur score
        return empty($this->scores) ? null : min($this->scores); // Vérifie si le tableau $scores est vide
    }

    public function getAllScores() { // Méthode publique qui retourne tous les scores
        return $this->scores; // Retourne le tableau complet des scores
    }
}
