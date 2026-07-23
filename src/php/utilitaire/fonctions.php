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
            round(sum(cp.teneur_valeur*cf.coef) FILTER (WHERE cp.const_code = 333))   AS "333",
            round(sum(cp.teneur_valeur*cf.coef) FILTER (WHERE cp.const_code = 400))   AS "400",
            round(sum(cp.teneur_valeur*cf.coef) FILTER (WHERE cp.const_code = 25000)) AS "25000",
            round(sum(cp.teneur_valeur*cf.coef) FILTER (WHERE cp.const_code = 31000)) AS "31000",
            round(sum(cp.teneur_valeur*cf.coef) FILTER (WHERE cp.const_code = 40000)) AS "40000"
        FROM composition cp
        INNER JOIN unnest(:codes::int[], :coefs::numeric[]) AS cf(alim_code, coef)
            ON cp.alim_code = cf.alim_code
        WHERE cp.const_code IN (31000, 40000, 25000, 333, 400)';

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