<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/classes/Database.php';
require_once __DIR__ . '/classes/Game.php';
require_once __DIR__ . '/classes/Card.php';
require_once __DIR__ . '/classes/Player.php';
require_once __DIR__ . '/classes/Scoreboard.php';
?>