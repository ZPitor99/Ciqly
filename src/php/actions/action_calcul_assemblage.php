<?php

require_once join(DIRECTORY_SEPARATOR,array(__DIR__,'..', 'utilitaire', 'fonctions.php'));

session_start();

if (isset($_POST['assemblage'])) {

    $_SESSION['tab_stat'] = [];
    $_SESSION['graphique1'] = [];
    $_SESSION['graphique2'] = [];

    $alim_codes = [];
    $alim_coef = [];
    $masse = 0;

    foreach ($_POST as $key => $value) {
        if (!ctype_digit((string)$key)) {
            continue;
        } elseif ($value === '' || !is_numeric($value) || (float)$value <= 0) {
            continue;
        }
        $alim_codes[] = filter_var($key, FILTER_VALIDATE_INT);
        $coef = filter_var($value, FILTER_VALIDATE_FLOAT);
        if ($coef !== false) {
            $alim_coef[] = $coef/100;
            $masse = $masse + $coef;
        }
        else {
            $alim_coef[] = $coef;
        }
    }

    //TODO: AJOUTER LA SAUVEGARDE DE LA QUANTITE

    if (empty($alim_codes) || in_array(false, $alim_codes, true) || in_array(false, $alim_coef, true)) {
        header('Location: /assemblage');
        exit;
    }

    //Tableau
    $data1 = assemblage_tableau($alim_codes);
    //Eau + Graphique
    $data2 = assemblage_graphique($alim_codes, $alim_coef);

    //data1
    $_SESSION['tab_stat'] = $data1;
    //data2
    if ($data2 != []){
        $_SESSION['graphique1'] = [
            'poids_total_g' => $masse,
            'eau_g' => $data2["400"],
        ];
        $_SESSION['graphique2'] = [
            'calories' => ['recommandee' => 2000, 'calculee' => $data2["333"]],
            'proteines' => ['recommandee' => 80, 'calculee' => $data2["25000"]],
            'glucides' => ['recommandee' => 265, 'calculee' => $data2["31000"]],
            'lipides' => ['recommandee' => 85, 'calculee' => $data2["40000"]],
        ];
    }
    $_SESSION['calcul_assemblage'] = true;
    header('Location: /assemblage');
    exit;
}
header('Location: /');
exit;
