<?php
require_once __DIR__ . '/../config.php';
// ...existing code...

// Récupère l'action demandée (ex: ?action=login ou via POST 'action')
$action = $_REQUEST['action'] ?? 'home';

// Helper simple pour sortie JSON (API)
function json_response($data, $code = 200) {
    header('Content-Type: application/json', true, $code);
    echo json_encode($data);
    exit;
}

// Utilise la classe Player pour l'auth
$auth = new Player();

switch ($action) {
    case 'login':
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /login.php');
            exit;
        }
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        if ($username === '' || $password === '') {
            $_SESSION['flash'] = 'Remplissez tous les champs';
            header('Location: /login.php');
            exit;
        }
        if ($auth->login($username, $password)) {
            session_regenerate_id(true);
            header('Location: /dashboard.php');
            exit;
        }
        $_SESSION['flash'] = 'Identifiants invalides';
        header('Location: /login.php');
        exit;

    case 'logout':
        // Déconnexion simple : supprime la session utilisateur
        if (session_status() === PHP_SESSION_ACTIVE) {
            unset($_SESSION['user']);
            session_regenerate_id(true);
        }
        header('Location: /');
        exit;

    case 'api_login':
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            json_response(['error' => 'Méthode non autorisée'], 405);
        }
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        if ($auth->login($username, $password)) {
            session_regenerate_id(true);
            json_response(['ok' => true, 'user' => $_SESSION['user']]);
        }
        json_response(['ok' => false, 'error' => 'Identifiants invalides'], 401);

    case 'register':
        header('Location: /register.php');
        exit;

    case 'home':
    default:
        include __DIR__ . '/../views/index.php';
        break;
}
?>