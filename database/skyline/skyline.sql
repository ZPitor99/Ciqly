-- Skyline : maximiser teneur_valeur et maximiser code_confiance
SELECT
    sk.const_nom_fr,
    count(*)
FROM (
    SELECT
        reff.const_nom_fr,
        trv.alim_code,
        alm.alim_nom_fr,
        trv.teneur_valeur,
        trv.code_confiance
    FROM
        (
            SELECT
                C1.alim_code,
                C1.const_code,
                C1.teneur_valeur,
                C1.code_confiance
            FROM
                ciqly_data.composition C1
            WHERE
                C1.code_confiance IS NOT NULL -- constituant définie
              AND NOT EXISTS (
                SELECT
                    1
                FROM
                    ciqly_data.composition C2
                WHERE
                    C2.const_code = C1.const_code -- même constituant
                  AND C2.teneur_valeur >= C1.teneur_valeur -- teneur meilleur ou égal
                  AND C2.code_confiance <= C1.code_confiance -- indice_confiance meilleur ou égal
                  AND (
                    C2.teneur_valeur > C1.teneur_valeur
                        OR C2.code_confiance < C1.code_confiance
                    ) -- et un des deux surpasse
            )
        ) trv
            INNER JOIN ciqly_data.constituants reff ON reff.const_code = trv.const_code
            INNER JOIN ciqly_data.aliments alm ON alm.alim_code = trv.alim_code
    ORDER BY
        reff.const_nom_fr ASC,
        trv.alim_code ASC,
        trv.code_confiance DESC) sk
GROUP BY
    sk.const_nom_fr;



DROP MATERIALIZED VIEW ciqly_data.MVW_skyline_m_tval_m_cdeconf;
CREATE MATERIALIZED VIEW ciqly_data.MVW_skyline_m_tval_m_cdeconf AS (
    -- Skyline : maximiser teneur_valeur et maximiser code_confiance
    SELECT
        reff.const_nom_fr,
        alm.alim_nom_fr,
        round(trv.teneur_valeur, 2) AS teneur_valeur,
        trv.code_confiance
    FROM
        (
            SELECT
                C1.alim_code,
                C1.const_code,
                C1.teneur_valeur,
                C1.code_confiance
            FROM
                ciqly_data.composition C1
            WHERE
                C1.code_confiance IS NOT NULL -- constituant définie
              AND NOT EXISTS (
                SELECT
                    1
                FROM
                    ciqly_data.composition C2
                WHERE
                    C2.const_code = C1.const_code -- même constituant
                  AND C2.teneur_valeur >= C1.teneur_valeur -- teneur meilleur ou égal
                  AND C2.code_confiance <= C1.code_confiance -- indice_confiance meilleur ou égal
                  AND (
                    C2.teneur_valeur > C1.teneur_valeur
                        OR C2.code_confiance < C1.code_confiance
                    ) -- et un des deux surpasse
            )
        ) trv
            INNER JOIN ciqly_data.constituants reff ON reff.const_code = trv.const_code
            INNER JOIN ciqly_data.aliments alm ON alm.alim_code = trv.alim_code
    WHERE
        reff.const_code = ANY(ciqly_data.ciqly_const_codes())
        AND reff.const_nom_fr NOT LIKE 'Eau%'
        AND reff.const_nom_fr NOT LIKE 'Energie,%'
    ORDER BY
        reff.const_nom_fr ASC,
        trv.alim_code ASC,
        trv.code_confiance DESC
)WITH NO DATA;
REFRESH MATERIALIZED VIEW ciqly_data.MVW_skyline_m_tval_m_cdeconf;
COMMENT ON MATERIALIZED VIEW ciqly_data.MVW_skyline_m_tval_m_cdeconf IS 'Aliment ayant la plus haute teneur pour chaque nutriment et une confiance élevée';


SELECT * FROM ciqly_data.MVW_skyline_m_tval_m_cdeconf;

-- Skyline : maximiser teneur_valeur, minimiser (teneur_max - teneur_min)
SELECT
    reff.const_nom_fr,
    trv.alim_code,
    alm.alim_nom_fr,
    trv.teneur_valeur,
    (trv.teneur_max - trv.teneur_min)
FROM
    (
        SELECT DISTINCT c1.*
        FROM ciqly_data.composition c1
        WHERE teneur_min IS NOT NULL
          AND teneur_max IS NOT NULL
          AND NOT EXISTS (
            SELECT 1
            FROM ciqly_data.composition c2
            WHERE c2.teneur_min IS NOT NULL
              AND c2.teneur_max IS NOT NULL
              AND c2.teneur_valeur >= c1.teneur_valeur
              AND (c2.teneur_max - c2.teneur_min) <= (c1.teneur_max - c1.teneur_min)
              AND (
                c2.teneur_valeur > c1.teneur_valeur
                    OR (c2.teneur_max - c2.teneur_min) < (c1.teneur_max - c1.teneur_min)
                )
        )
    ) trv
        INNER JOIN ciqly_data.constituants reff ON reff.const_code = trv.const_code
        INNER JOIN ciqly_data.aliments alm ON alm.alim_code = trv.alim_code
ORDER BY
    reff.const_nom_fr,
    trv.alim_code,
    trv.code_confiance DESC;