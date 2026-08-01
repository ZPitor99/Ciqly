<?php
require_once join(DIRECTORY_SEPARATOR, array(__DIR__, '..', 'prive', 'connection.php'));
require_once join(DIRECTORY_SEPARATOR, array(__DIR__, '..', 'class', 'Detective.php'));
require_once join(DIRECTORY_SEPARATOR, array(__DIR__, '..', 'class', 'Journaliste.php'));

function toutesDefinies(array $cles): bool
{
    foreach ($cles as $cle) {
        if (empty($_SESSION[$cle])) {
            return false;
        }
    }
    return true;
}

$pdo = Database::get();
$detective = new Detective($_SERVER['HTTP_USER_AGENT']);
$journaliste = new Journaliste($pdo, $detective);

