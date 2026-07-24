<?php
session_start();

if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = [];
    header('Location: /');
}
else{
    $id = $_POST['alim_code'] ?? null;
    $nom = $_POST['alim_nom'] ?? null;
    $retour = $_POST['retour'] ?? '/';

    $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

    if ($id !== null) {
        if (!in_array($id, array_keys($_SESSION['panier']))) {
            $_SESSION['panier'][htmlspecialchars($id)] = ["nom" => htmlspecialchars($nom), "quantite" => 100];
        } else{
            unset($_SESSION['panier'][htmlspecialchars($id)]);
        }
    }

    if (str_starts_with($retour, '/')) {
        header('Location: ' . $retour . '#liste_aliments');
    } else {
        header('Location: /');
    }
    exit;
}
exit;