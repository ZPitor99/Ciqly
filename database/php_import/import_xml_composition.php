<?php
$xml = simplexml_load_file("../../dataverse_files/compo_2025_11_03.xml");
if ($xml === false) {
    die("Erreur lors du chargement du fichier XML");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des compositions alimentaires</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #999;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #eee;
        }
    </style>
</head>
<body>

<h2>Compositions alimentaires</h2>

<table>
    <thead>
    <tr>
        <th>Alim Code</th>
        <th>Const Code</th>
        <th>Teneur</th>
        <th>Min</th>
        <th>Max</th>
        <th>Code Confiance</th>
        <th>Source code</th>

    </tr>
    </thead>
    <tbody>
    <?php foreach ($xml->COMPO as $grp): ?>
        <tr>
            <td><?= htmlspecialchars($grp->alim_code) ?></td>
            <td><?= htmlspecialchars($grp->const_code) ?></td>
            <td><?= htmlspecialchars($grp->teneur) ?></td>
            <td><?= htmlspecialchars($grp->min) ?></td>
            <td><?= htmlspecialchars($grp->max) ?></td>
            <td><?= htmlspecialchars($grp->code_confiance) ?></td>
            <td><?= htmlspecialchars($grp->source_code) ?></td>

        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>