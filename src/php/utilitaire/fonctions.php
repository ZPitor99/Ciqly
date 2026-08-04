<?php

require_once join(DIRECTORY_SEPARATOR, array(__DIR__, '..', 'prive', 'connection.php'));

function peupler_aliment($groupe, $sousGroupe, $sousSousGroupe): ?array
{
    $pdo = Database::get();

    if ($groupe !== null) {
        $groupe = sprintf('%02d', $groupe);
        $sql = 'SELECT alim_code, alim_nom_fr, alim_nom_eng FROM ciqly_data.aliments WHERE alim_grp_code = :groupe';
        $bindings = ['groupe' => $groupe];

        if ($sousGroupe !== 'all') {
            $sql .= ' AND alim_ssgrp_code = :ssgroupe';
            $bindings['ssgroupe'] = $sousGroupe;
        }
        elseif ($sousSousGroupe !== 'all') {
            $sql .= ' AND alim_ssssgrp_code = :ssssgroupe';
            $bindings['ssssgroupe'] = $sousSousGroupe;
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
            ciqly_data.eval_confiance(string_agg(c.code_confiance, '')) AS concat_conf
        FROM
            ciqly_data.composition c
                inner join ciqly_data.aliments a on a.alim_code = c.alim_code
        WHERE
            c.const_code = ANY(ciqly_data.ciqly_const_codes())
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

        $sql = "SELECT
            cp.const_code AS t_cde,
            round(sum(cp.teneur_valeur*cf.coef)) AS t_cf
        FROM ciqly_data.composition cp
                INNER JOIN
            unnest(:codes::int[], :coefs::numeric[]) AS cf(alim_code, coef)
                ON cp.alim_code = cf.alim_code
        WHERE cp.const_code = ANY(ciqly_data.ciqly_const_codes())
        GROUP BY cp.const_code
        ORDER BY cp.const_code";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'codes' => prepare_pg_array($alim_codes),
            'coefs' => prepare_pg_array($alim_coef)
        ]);
        $rows = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

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

function assemblage_null($alim_codes): string{
    $pdo = Database::get();

    if ($alim_codes !== null) {

        $sql = "SELECT 
            ciqly_data.ciqly_const_assembl_null(:codes::int[]);";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'codes' => prepare_pg_array($alim_codes)
        ]);
        $rows = $stmt->fetch();

        if (empty($rows)) {
            $result = "";
        }
        else{
            $result = $rows['ciqly_const_assembl_null'];
        }
        return $result;
    }
    return "";
}

function assemblage_cache_nutriment_ref(): array
{
    $pdo = Database::get();

    $sql = "SELECT 
        nature,
        const_code,
        nom,
        unite,
        val_moy, 
        comm 
    FROM 
        ciqly_data.ciqly_cache_assemblage";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();

}