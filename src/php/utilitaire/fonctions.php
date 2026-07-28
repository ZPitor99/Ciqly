<?php

require_once join(DIRECTORY_SEPARATOR, array(__DIR__, '..', 'prive', 'connection.php'));

function peupler_aliment($groupe, $sousGroupe, $sousSousGroupe): ?array
{
    $pdo = Database::get();

    if ($groupe !== null) {
        $groupe = sprintf('%02d', $groupe);
        $sql = 'SELECT alim_code, alim_nom_fr, alim_nom_eng FROM aliments WHERE alim_grp_code = :groupe';
        $bindings = ['groupe' => $groupe];

        if ($sousSousGroupe !== 'all') {
            $sql .= ' AND alim_ssssgrp_code = :ssssgroupe';
            $bindings['ssssgroupe'] = $sousSousGroupe;
        } elseif ($sousGroupe !== 'all') {
            $sql .= ' AND alim_ssgrp_code = :ssgroupe';
            $bindings['ssgroupe'] = $sousGroupe;
        }

        $sql .= ' ORDER BY alim_nom_fr';

        $stmt = $pdo->prepare($sql);
        $stmt->execute($bindings);
        $rows = $stmt->fetchAll();

        if (empty($rows)) {
            $result = [];
        }
        else {
            $result = $rows;
        }
        return $result;
    }
    return null;
}


function prepare_pg_array(array $list): string{
    return '{'. implode(',', $list) .'}';
}


function assemblage_tableau($alim_codes): array
{
    $pdo = Database::get();

    if ($alim_codes !== null) {

        $sql = "SELECT
            count(DISTINCT a.alim_code) AS nb_aliment,
            count(DISTINCT a.alim_grp_code) AS distinct_grp,
            eval_confiance(string_agg(c.code_confiance, '')) AS concat_conf
        FROM
            composition c
                inner join aliments a on a.alim_code = c.alim_code
        WHERE
            (const_code=31000 or const_code=40000 or const_code=25000 or const_code=333 or const_code=400)
          AND c.alim_code = ANY(:codes::int[])";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'codes' => prepare_pg_array($alim_codes)
        ]);
        $rows = $stmt->fetch();

        if (empty($rows)) {
            $result = [];
        }
        else{
            $result = $rows;
        }
        return $result;
    }
    return [];
}

function assemblage_graphique($alim_codes, $alim_coef): array
{
    $pdo = Database::get();

    if ($alim_codes !== null && $alim_coef !== null && $alim_codes != [] && $alim_coef != []) {

        $sql = 'SELECT
            -- eau
            round(sum(cp.teneur_valeur*cf.coef) FILTER (WHERE cp.const_code = 400))   AS "400",
            -- graphique
            round(sum(cp.teneur_valeur*cf.coef) FILTER (WHERE cp.const_code = 333))   AS "333",
            round(sum(cp.teneur_valeur*cf.coef) FILTER (WHERE cp.const_code = 25000)) AS "25000",
            round(sum(cp.teneur_valeur*cf.coef) FILTER (WHERE cp.const_code = 31000)) AS "31000",
            round(sum(cp.teneur_valeur*cf.coef) FILTER (WHERE cp.const_code = 40000)) AS "40000",
            -- minéraux
            round(sum(cp.teneur_valeur*cf.coef) FILTER (WHERE cp.const_code = 10110)) AS "10110",
            round(sum(cp.teneur_valeur*cf.coef) FILTER (WHERE cp.const_code = 10120)) AS "10120",
            round(sum(cp.teneur_valeur*cf.coef) FILTER (WHERE cp.const_code = 10150)) AS "10150",
            round(sum(cp.teneur_valeur*cf.coef) FILTER (WHERE cp.const_code = 10190)) AS "10190",
            round(sum(cp.teneur_valeur*cf.coef) FILTER (WHERE cp.const_code = 10200)) AS "10200",
            round(sum(cp.teneur_valeur*cf.coef) FILTER (WHERE cp.const_code = 10260)) AS "10260",
            round(sum(cp.teneur_valeur*cf.coef) FILTER (WHERE cp.const_code = 10290)) AS "10290",
            round(sum(cp.teneur_valeur*cf.coef) FILTER (WHERE cp.const_code = 10300)) AS "10300",
            round(sum(cp.teneur_valeur*cf.coef) FILTER (WHERE cp.const_code = 10340)) AS "10340",
            round(sum(cp.teneur_valeur*cf.coef) FILTER (WHERE cp.const_code = 10530)) AS "10530",
            -- vitamine
            round(sum(cp.teneur_valeur*cf.coef) FILTER (WHERE cp.const_code = 51104)) AS "51104",
            round(sum(cp.teneur_valeur*cf.coef) FILTER (WHERE cp.const_code = 55100)) AS "55100",
            round(sum(cp.teneur_valeur*cf.coef) FILTER (WHERE cp.const_code = 52100)) AS "52100",
            round(sum(cp.teneur_valeur*cf.coef) FILTER (WHERE cp.const_code = 71010)) AS "71010",
            round(sum(cp.teneur_valeur*cf.coef) FILTER (WHERE cp.const_code = 54101)) AS "54101",
            -- nutriment compl
            round(sum(cp.teneur_valeur*cf.coef) FILTER (WHERE cp.const_code = 32410)) AS "32410",
            round(sum(cp.teneur_valeur*cf.coef) FILTER (WHERE cp.const_code = 34100)) AS "34100",
            round(sum(cp.teneur_valeur*cf.coef) FILTER (WHERE cp.const_code = 75100)) AS "75100"
        FROM composition cp
                 INNER JOIN unnest(:codes::int[], :coefs::numeric[]) AS cf(alim_code, coef)
                            ON cp.alim_code = cf.alim_code
        WHERE cp.const_code = ANY(ciqly_const_codes())';

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'codes' => prepare_pg_array($alim_codes),
            'coefs' => prepare_pg_array($alim_coef)
        ]);
        $rows = $stmt->fetch();

        if (empty($rows)) {
            $result = [];
        }
        else{
            $result = $rows;
        }
        return $result;
    }
    return [];
}