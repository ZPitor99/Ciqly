<?php
$xml = simplexml_load_file("../../dataverse_files/const_2025_11_03.xml");
if ($xml === false) {
    die("Erreur lors du chargement du fichier XML");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des constantes</title>
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

<h2>Constantes</h2>

<table>
    <thead>
    <tr>
        <th>Const Code</th>
        <th>Const nom fr</th>
        <th>Const nom eng</th>
        <th>Code INFOODS</th>

    </tr>
    </thead>
    <tbody>
    <?php foreach ($xml->CONST as $grp): ?>
        <tr>
            <td><?= htmlspecialchars($grp->const_code) ?></td>
            <td><?= htmlspecialchars($grp->const_nom_fr) ?></td>
            <td><?= htmlspecialchars($grp->const_nom_eng) ?></td>
            <td><?= htmlspecialchars($grp->code_INFOODS) ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>