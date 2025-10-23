<?php

include_once '../config.php';


class Player { // Classe représentant un joueur
    private $name; // Nom du joueur
    private $score; // Score du joueur
    private $id; // ID du joueur
    private $username; // Nom d'utilisateur du joueur
    private $password; // Mot de passe du joueur
    private $bestScore; // Meilleur score du joueur
    private $db; // Instance de la base de données

    public function __construct($username = null) {
        $this->username = $username;
        $this->db = Database::getInstance(); // Initialise la base de données
    }


    public function register($username, $password) {
        $stmt = $this->db->prepare("INSERT INTO users(username,password) VALUES(?,?)");
        $stmt->execute([$username, password_hash($password, PASSWORD_DEFAULT)]);
            // Vérifie si l'utilisateur existe déjà
            // Hash le mot de passe
            // Enregistre dans la base de données
            // Initialise la session (connexion auto après inscription)
    }

    public function login($username, $password) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username=?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;
            return true;
            // Recherche l'utilisateur par nom
            // Vérifie le mot de passe avec password_verify()
            // Si OK, charge les données dans l'objet
            // Et initialise la session
        }
    }
     
    public function updateScore($score) {
        $this->score += $score; // Met à jour le score actuel
        if ($this->score > $this->bestScore) { // Si le score actuel est supérieur au meilleur score
            $this->bestScore = $this->score; // Met à jour le meilleur score
            $stmt = $this->db->prepare("UPDATE users SET bestScore=? WHERE id=?"); // Prépare la requête SQL
            $stmt->execute([$this->bestScore, $this->id]); // Exécute la requête pour mettre à jour le meilleur score en base
        }
            // Compare avec bestScore
            // Si meilleur : mettre à jour dans l'objet et en base
    }

    public function getName() { // Getter pour le nom
        return $this->name; // Retourne le nom du joueur
    }

    public function getScore() { // Getter pour le score
        return $this->score; // Retourne le score du joueur
    }

    public function incrementScore($points) { // Méthode pour incrémenter le score
        $this->score += $points; // Ajoute les points au score actuel
    }
   
}