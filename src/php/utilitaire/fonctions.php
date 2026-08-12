<?php

require_once join(DIRECTORY_SEPARATOR, array(__DIR__, '..', 'prive', 'connection.php'));


/**
 * @param $groupe ?string identifiant du groupe
 * @param $sousGroupe ?string identifiant du sous-groupe
 * @param $sousSousGroupe ?string identifiant du sous-sous-groupe
 * @return array|null Tableau associatif des aliments présent dans les types de groupes définis
 */
function peupler_aliment(?string $groupe, ?string $sousGroupe, ?string $sousSousGroupe): ?array
{
    if ($groupe !== null) {
        try {
            $groupe = sprintf('%02d', $groupe);

            $pdo = Database::get();

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

        }catch (Exception){
            return null;
        }
    }
    return null;
}

/**
 * Formatage de l'array php pour requête PostgreSQL.
 * @param array $list La liste des éléments à transformer
 * @return string La liste formatée pour PostgreSQL
 */
function prepare_pg_array(array $list): string{
    return '{'. implode(',', $list) .'}';
}

/**
 * @param $alim_codes ?array Liste des aliments codes
 * @return array Informations générales sur les aliments choisis dans $alim_codes
 */
function assemblage_tableau(?array $alim_codes): array
{
    if ($alim_codes !== null) {
        try {
            $pdo = Database::get();

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
        }catch (Exception){
            return [];
        }
    }
    return [];
}


/**
 * @param $alim_codes ?array Liste des codes aliments
 * @param $alim_coef ?array Liste des quantités associées aux aliments codes
 * @return array Tableau associatif des constituants avec leurs valeurs calculées
 */
function assemblage_graphique(?array $alim_codes, ?array $alim_coef): array
{
    if ($alim_codes !== null && $alim_coef !== null && $alim_codes != [] && $alim_coef != []) {

        try {
            $pdo = Database::get();

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
        }catch (Exception){
            return [];
        }
    }
    return [];
}


/**
 * @param $alim_codes ?array La liste des codes aliment.
 * @return string La concaténation des aliments et de leurs constituants avec une valeur non définie
 */
function assemblage_null(?array $alim_codes): string{
    if ($alim_codes !== null) {
        try{
            $pdo = Database::get();

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
        }catch (Exception){
            return "";
        }
    }
    return "";
}

/**
 * @return array Tableau associatif pour le cache nutriment_ref.php
 */
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


/**
 * @return array Résultat de la requête skyline stocké dans la vue matérialisé - Skyline : maximiser teneur_valeur et maximiser code_confiance
 */
function skyline_req(): array
{
    try {
        $pdo = Database::get();

        $sql = "SELECT 
            * 
        FROM 
            ciqly_data.MVW_skyline_m_tval_m_cdeconf";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    catch (Exception){
        return [];
    }
}