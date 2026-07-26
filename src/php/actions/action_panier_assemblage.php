<?php
session_start();
header('Content-Type: application/json');

$input  = json_decode(file_get_contents('php://input'), true);
$action = $input['action'] ?? null;
$id     = $input['id'] ?? null;

if (!$id || !isset($_SESSION['panier'][$id])) {
    echo json_encode(['success' => false, 'message' => 'Article introuvable']);
    header('Location: /assemblage');
    exit;
}

switch ($action) {
    case 'reset':
        $_SESSION['panier'][$id]['quantite'] = 0;
        break;

    case 'supprimer':
        unset($_SESSION['panier'][$id]);
        break;

    case 'monter':
    case 'descendre':
        $keys  = array_keys($_SESSION['panier']);
        $index = array_search($id, $keys);

        $swapIndex = null;
        if ($action === 'monter' && $index > 0) {
            $swapIndex = $index - 1;
        } elseif ($action === 'descendre' && $index < count($keys) - 1) {
            $swapIndex = $index + 1;
        }

        if ($swapIndex !== null) {
            $panier = $_SESSION['panier'];
            $ordre  = $keys;
            [$ordre[$index], $ordre[$swapIndex]] = [$ordre[$swapIndex], $ordre[$index]];

            $nouveauPanier = [];
            foreach ($ordre as $k) {
                $nouveauPanier[$k] = $panier[$k];
            }
            $_SESSION['panier'] = $nouveauPanier;
        }
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Action inconnue']);
        header('Location: /assemblage');
        exit;
}

echo json_encode(['success' => true]);
header('Location: /assemblage');
exit;
