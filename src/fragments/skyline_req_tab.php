<?php

require_once join(DIRECTORY_SEPARATOR, array(__DIR__, '..', 'php', 'utilitaire', 'fonctions.php'));

$data = skyline_req();
?>
<table>
    <caption>Résultat de la requête skyline</caption>
    <thead>
    <tr>
        <th>Nutriment</th>
        <th>Aliment</th>
        <th>Teneur</th>
        <th>Code de confiance</th>
    </tr>
    </thead>
    <tbody>

<?php
    for ($i = 0; $i < count($data); $i++) {
    $courant = $data[$i];
    $nutriment = htmlspecialchars($courant["const_nom_fr"]);
    $aliment = htmlspecialchars($courant["alim_nom_fr"]);
    $teneur = htmlspecialchars($courant["teneur_valeur"]);
    $code = htmlspecialchars($courant["code_confiance"]);
    echo <<<HTML
        <tr>
            <td>$nutriment</td>
            <td>$aliment</td>
            <td>$teneur</td>
            <td>$code</td>
        </tr>
        HTML;
}
?>
    </tbody>
</table>


