<?php
require_once 'auth.php';

// Zmazanie dát z relácie
$_SESSION = [];

// Zničenie cookies relácie, ak existujú
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Zničenie relácie
session_destroy();

// Presmerovanie na hlavnú stránku
header("Location: index.php");
exit;
?>
