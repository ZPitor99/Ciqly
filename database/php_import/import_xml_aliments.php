<?php
$xml = simplexml_load_file("../../dataverse_files/alim_2025_11_03.xml");
if ($xml === false) {
    die("Erreur lors du chargement du fichier XML");
}

// Convertir les données XML en tableau pour faciliter le tri
$data = [];
foreach ($xml->ALIM as $alim) {
    $data[] = [
            'alim_code' => (string)$alim->alim_code,
            'alim_nom_fr' => (string)$alim->alim_nom_fr,
            'alim_nom_eng' => (string)$alim->alim_nom_eng,
            'alim_nom_sci' => (string)$alim->alim_nom_sci,
            'alim_grp_code' => (string)$alim->alim_grp_code,
            'alim_ssgrp_code' => (string)$alim->alim_ssgrp_code,
            'alim_ssssgrp_code' => (string)$alim->alim_ssssgrp_code,
            'facteur_Jones' => (string)$alim->facteur_Jones,
    ];
}

// Gérer le tri
$sort_column = isset($_GET['sort']) ? $_GET['sort'] : '';
$sort_order = isset($_GET['order']) && $_GET['order'] === 'desc' ? 'desc' : 'asc';

if ($sort_column && array_key_exists($sort_column, $data[0] ?? [])) {
    usort($data, function($a, $b) use ($sort_column, $sort_order) {
        $val_a = $a[$sort_column];
        $val_b = $b[$sort_column];

        // Comparaison numérique si les deux valeurs sont numériques
        if (is_numeric($val_a) && is_numeric($val_b)) {
            $result = $val_a <=> $val_b;
        } else {
            $result = strcasecmp($val_a, $val_b);
        }

        return $sort_order === 'desc' ? -$result : $result;
    });
}

// Fonction pour générer les liens de tri
function getSortLink($column, $current_sort, $current_order) {
    $new_order = ($current_sort === $column && $current_order === 'asc') ? 'desc' : 'asc';
    return "?sort=" . urlencode($column) . "&order=" . urlencode($new_order);
}

// Fonction pour afficher l'indicateur de tri
function getSortIndicator($column, $current_sort, $current_order) {
    if ($current_sort === $column) {
        return $current_order === 'asc' ? ' ▲' : ' ▼';
    }
    return '';
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des aliments Ciqual</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #999;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #eee;
            cursor: pointer;
            user-select: none;
            position: relative;
        }
        th:hover {
            background-color: #ddd;
        }
        th a {
            color: #333;
            text-decoration: none;
            display: block;
            width: 100%;
        }
        th a:hover {
            color: #000;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f0f0f0;
        }
        .sort-indicator {
            font-size: 0.8em;
            color: #666;
        }
    </style>
</head>
<body>

<h2>Aliments</h2>
<p>Cliquez sur les en-têtes de colonnes pour trier le tableau.</p>

<table>
    <thead>
    <tr>
        <th>
            <a href="<?= getSortLink('alim_code', $sort_column, $sort_order) ?>">
                Alim Code<span class="sort-indicator"><?= getSortIndicator('alim_code', $sort_column, $sort_order) ?></span>
            </a>
        </th>
        <th>
            <a href="<?= getSortLink('alim_nom_fr', $sort_column, $sort_order) ?>">
                Alim Nom fr<span class="sort-indicator"><?= getSortIndicator('alim_nom_fr', $sort_column, $sort_order) ?></span>
            </a>
        </th>
        <th>
            <a href="<?= getSortLink('alim_nom_eng', $sort_column, $sort_order) ?>">
                Alim Nom eng<span class="sort-indicator"><?= getSortIndicator('alim_nom_eng', $sort_column, $sort_order) ?></span>
            </a>
        </th>
        <th>
            <a href="<?= getSortLink('alim_nom_sci', $sort_column, $sort_order) ?>">
                Alim Nom sci<span class="sort-indicator"><?= getSortIndicator('alim_nom_sci', $sort_column, $sort_order) ?></span>
            </a>
        </th>
        <th>
            <a href="<?= getSortLink('alim_grp_code', $sort_column, $sort_order) ?>">
                Alim grp code<span class="sort-indicator"><?= getSortIndicator('alim_grp_code', $sort_column, $sort_order) ?></span>
            </a>
        </th>
        <th>
            <a href="<?= getSortLink('alim_ssgrp_code', $sort_column, $sort_order) ?>">
                Alim ssgrp code<span class="sort-indicator"><?= getSortIndicator('alim_ssgrp_code', $sort_column, $sort_order) ?></span>
            </a>
        </th>
        <th>
            <a href="<?= getSortLink('alim_ssssgrp_code', $sort_column, $sort_order) ?>">
                Alim ssssgrp code<span class="sort-indicator"><?= getSortIndicator('alim_ssssgrp_code', $sort_column, $sort_order) ?></span>
            </a>
        </th>
        <th>
            <a href="<?= getSortLink('facteur_Jones', $sort_column, $sort_order) ?>">
                Facteur Jones<span class="sort-indicator"><?= getSortIndicator('facteur_Jones', $sort_column, $sort_order) ?></span>
            </a>
        </th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($data as $row): ?>
        <tr>
            <td><?= htmlspecialchars($row['alim_code']) ?></td>
            <td><?= htmlspecialchars($row['alim_nom_fr']) ?></td>
            <td><?= htmlspecialchars($row['alim_nom_eng']) ?></td>
            <td><?= htmlspecialchars($row['alim_nom_sci']) ?></td>
            <td><?= htmlspecialchars($row['alim_grp_code']) ?></td>
            <td><?= htmlspecialchars($row['alim_ssgrp_code']) ?></td>
            <td><?= htmlspecialchars($row['alim_ssssgrp_code']) ?></td>
            <td><?= htmlspecialchars($row['facteur_Jones']) ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>