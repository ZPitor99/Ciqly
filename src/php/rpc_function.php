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

function rpc_groupeToSousGroupe(PDO $pdo): object
{
    $stmt = $pdo->prepare('SELECT id AS num, alim_ssgroupe_code AS id, alim_ssgroupe_fr AS nom, alim_ssgroupe_eng AS nom_en FROM VW_GROUPE_SSGROUPE_ID ORDER BY alim_ssgroupe_fr');
    $stmt->execute();

    $rows = $stmt->fetchAll();

    $result = [];
    if (empty($rows)) {
        throw new InvalidArgumentException('Erreur BD');
    }
    else {
        foreach ($rows as $row) {
            $num = (string) $row['num'];
            $result[$num][] = [
                'id'  => $row['id'],
                'nom' => $row['nom'],
                'nom_en' => $row['nom_en'],
            ];
        }
    }
    return (object) $result;
}


function rpc_sousGroupeToSousSousGroupe(PDO $pdo): object
{
    $stmt = $pdo->prepare('SELECT alim_ssgroupe_code AS num , alim_ssssgroupe_code AS id, alim_ssssgroupe_fr AS nom, alim_ssssgroupe_eng AS nom_en FROM VW_SSGROUPE_SSSSGROUPE_NUM ORDER BY alim_ssssgroupe_fr');
    $stmt->execute();

    $result = [];
    $rows = $stmt->fetchAll();
    if (empty($rows)) {
        throw new InvalidArgumentException('Erreur BD');
    }
    else {
        foreach ($rows as $row) {
            $num = (string) $row['num'];
            $result[$num][] = [
                'id'  => $row['id'],
                'nom' => $row['nom'],
                'nom_en' => $row['nom_en'],
            ];
        }
    }
    return (object) $result;
}