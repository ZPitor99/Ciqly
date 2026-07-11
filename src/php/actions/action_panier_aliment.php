<?php
session_start();

if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = [];
}

$id = $_POST['alim_code'] ?? null;
$nom = $_POST['alim_nom'] ?? null;
$action = $_POST['action'] ?? null;
$retour = $_POST['retour'] ?? '/';

if ($id !== null) {
    if ($action === 'ajouter' && !in_array($id, array_keys($_SESSION['panier']), true)) {
        $_SESSION['panier'][$id] = ["nom" => $nom, "quantite" => 100];
    } elseif ($action === 'retirer') {
        unset($_SESSION['panier'][$id]);
    }
}

if (str_starts_with($retour, '/')) {
    header('Location: ' . $retour . '#liste_aliments');
} else {
    header('Location: /');
}
exit;