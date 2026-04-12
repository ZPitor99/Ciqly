<?php
declare(strict_types=1);
require_once __DIR__ . '/configuration/config.php';
require_once __DIR__ . '/configuration/connection.php';
require_once __DIR__ . '/Router.php';
require_once __DIR__ . '/Reponse.php';

header('Content-Type: application/json; charset=UTF-8');
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('Referrer-Policy: no-referrer');

// Autoriser uniquement GET
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    Reponse::error('Méthode non autorisée', 405);
}

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$router = new Router($uri);
$router->dispatch();