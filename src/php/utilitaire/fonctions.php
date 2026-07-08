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