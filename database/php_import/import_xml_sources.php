<?php
$xml = simplexml_load_file("../../dataverse_files/sources_2025_11_03.xml");
if ($xml === false) {
    die("Erreur lors du chargement du fichier XML");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des sources des données Ciqual</title>
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

<h2>Sources</h2>

<table>
    <thead>
    <tr>
        <th>Source code</th>
        <th>Ref citation</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($xml->SOURCES as $grp): ?>
        <tr>
            <td><?= htmlspecialchars($grp->source_code) ?></td>
            <td><?= htmlspecialchars($grp->ref_citation) ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>