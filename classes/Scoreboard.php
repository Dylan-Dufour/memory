<?php // classes/Scoreboard.php
require_once 'Database.php'; // Assuming Database.php contains the Database class for DB connection

class Scoreboard { // Manages game scores and leaderboards
    private $db; // Database connection

    public function __construct() { // Initialize database connection
        $database = new Database(); // Create a new Database instance
        $this->db = $database->connect(); // Connect to the database
    }

    public function getTop10() { // Retrieve top 10 scores from the leaderboard
        $query = $this->db->query("
            SELECT u.username, l.best_score 
            FROM leaderboard l
            JOIN users u ON u.id = l.user_id
            ORDER BY l.best_score DESC
            LIMIT 10
        ");
        return $query->fetchAll(PDO::FETCH_ASSOC); // Fetch and return results as an associative array
    }

    public function getUserScores($userId) { // Retrieve last 5 scores for a specific user
        $query = $this->db->prepare("
            SELECT score, played_at 
            FROM games 
            WHERE user_id = ?
            ORDER BY score DESC
            LIMIT 5
        ");
        $query->execute([$userId]); // Execute the prepared statement with the user ID
        return $query->fetchAll(PDO::FETCH_ASSOC); // Fetch and return results as an associative array
    }
}
?>
