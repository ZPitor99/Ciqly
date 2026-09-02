<?php

require_once join(DIRECTORY_SEPARATOR, array(__DIR__, '..', 'utilitaire', 'fonctions.php'));
require_once join(DIRECTORY_SEPARATOR,array(__DIR__,'..','utilitaire','reportage.php'));

if (isset($_POST['assemblage'])) {

    $_SESSION['tab_stat'] = [];
    $_SESSION['graphique1'] = [];
    $_SESSION['graphique2'] = [];

    $alim_codes = [];
    $alim_coef = [];
    $masse = 0;

    foreach ($_POST as $key => $value) {

        if (!ctype_digit((string)$key) || $value === '' || !is_numeric($value) || (float)$value <= 0) {
            continue;
        }

        $alim_codes[] = filter_var($key, FILTER_VALIDATE_INT);
        $coef = filter_var(str_replace(',', '.', trim($value)), FILTER_VALIDATE_FLOAT);
        if ($coef !== false and $coef < 100000 and $coef >= 0) {
            $_SESSION['panier'][end($alim_codes)]['quantite'] = $coef;
            $alim_coef[] = $coef / 100;
            $masse = $masse + $coef;
        } else {
            $alim_coef[] = false;
        }

        if (count($alim_codes) > 25) {
            break;
        }
    }

    if (empty($alim_codes) || in_array(false, $alim_codes, true) || in_array(false, $alim_coef, true) || count($alim_codes) > 25) {
        header('Location: /assemblage');
        exit;
    }

    $journaliste->logJournalRessource(93, "asbl", null, null, $alim_codes, $alim_coef);

    $cache_nutriment_ref = require join(DIRECTORY_SEPARATOR, array(__DIR__, '..', 'utilitaire', 'cache', 'nutriment_ref.php'));

    //Tableau
    $data1 = assemblage_tableau($alim_codes);
    //Eau + Graphique
    $data2 = assemblage_graphique($alim_codes, $alim_coef);
    //attribut null
    $data3 = assemblage_null($alim_codes);

    //data1
    $_SESSION['tab_stat'] = $data1;
    //data2
    if ($data2 != []) {
        $resultats = [];
        foreach ($cache_nutriment_ref as $code => $ref) {
            $resultats[$code] = array_merge($ref, ['valeur' => $data2[$code] ?? null]);
        }

        $tdb_type = [];

        foreach ($resultats as $code => $tuple) {
            $lettre = $tuple['nature'];
            $tdb_type[$lettre][$code] = $tuple;

        }

        $_SESSION['graphique1'] = [];
        $_SESSION['graphique2'] = [];
        $_SESSION['list_min'] = [];
        $_SESSION['list_vit'] = [];
        $_SESSION['tab_nut'] = [];

        foreach ($tdb_type as $num => $tuples) {
            foreach ($tuples as $code => $tuple) {
                if ($num == 'M') {
                    $_SESSION['list_min'][$code] = [
                        "nom" => $tuple['nom'],
                        "valeur" => $tuple['valeur'],
                        "unite" => $tuple['unite'],
                        "pourcentage" => round(((float)($tuple['valeur']) * 100) / (float)$tuple['val_moy']),
                    ];
                } elseif ($num == 'V') {
                    $_SESSION['list_vit'][$code] = [
                        "nom" => $tuple['nom'],
                        "valeur" => $tuple['valeur'],
                        "unite" => $tuple['unite'],
                        "pourcentage" => round(((float)($tuple['valeur']) * 100) / (float)$tuple['val_moy']),
                    ];
                } elseif ($num == 'G') {
                    $_SESSION['graphique2'][$tuple['nom']] = [
                        'recommandee' => $tuple['val_moy'],
                        'calculee' => $tuple['valeur']
                    ];

                } elseif ($num == 'N') {
                    $_SESSION['tab_nut'][$code] = [
                        "nom" => $tuple['nom'],
                        "valeur" => $tuple['valeur'],
                        "info" => $tuple['comm'],
                    ];
                } elseif ($num == 'E') {
                    $_SESSION['graphique1'] = [
                        'poids_total_g' => $masse,
                        'eau_g' => $tuple['valeur'],
                    ];
                }
            }
        }
    }
    $_SESSION['assemblage_null'] = $data3;
    $_SESSION['calcul_assemblage'] = true;
    header('Location: /assemblage');
    exit;
}
header('Location: /404');
exit;
