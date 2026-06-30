<?php

/**
 * Vérifie que les clés requises sont présentes et non vides dans $params.
 * @throws InvalidArgumentException si une clé manque
 */
function requireParams(array $params, array $required): void
{
    $missing = [];

    foreach ($required as $key) {
        if (!isset($params[$key]) || $params[$key] === '') {
            $missing[] = $key;
        }
    }

    if (!empty($missing)) {
        throw new InvalidArgumentException(
            'Paramètre(s) manquant(s) : ' . implode(', ', $missing)
        );
    }
}

function rpc_aliment(PDO $pdo, array $params): array
{
    requireParams($params, ['id']);

    $stmt = $pdo->prepare('SELECT * FROM aliments WHERE alim_code = :id');
    $stmt->execute(['id' => $params['id']]);

    $row = $stmt->fetch();
    if ($row === false) {
        throw new InvalidArgumentException('Aliment introuvable');
    }

    return $row;
}