-- Skyline : maximiser teneur_valeur ET maximiser code_confiance
-- Principe utilisé sans l'opérateur Skyline: retourné les tuples non dominés
SELECT
    REFF.CONST_NOM_FR,
    TRV.ALIM_CODE,
    ALM.ALIM_NOM_FR,
    TRV.TENEUR_VALEUR,
    TRV.CODE_CONFIANCE
FROM
    (
        SELECT
            C1.*
        FROM
            COMPOSITION C1
        WHERE
            C1.CODE_CONFIANCE IS NOT NULL
          AND NOT EXISTS (
            SELECT
                1
            FROM
                COMPOSITION C2
            WHERE
                C2.CONST_CODE = C1.CONST_CODE -- même constituant
              AND C2.TENEUR_VALEUR >= C1.TENEUR_VALEUR -- teneur meilleur ou égal
              AND C2.CODE_CONFIANCE <= C1.CODE_CONFIANCE -- indice_confiance meilleur ou égal
              AND (
                C2.TENEUR_VALEUR > C1.TENEUR_VALEUR
                    OR C2.CODE_CONFIANCE < C1.CODE_CONFIANCE
                ) -- et un des deux surpasse
        )
    ) TRV
        INNER JOIN CONSTITUANTS REFF ON REFF.CONST_CODE = TRV.CONST_CODE
        INNER JOIN ALIMENTS ALM ON ALM.ALIM_CODE = TRV.ALIM_CODE
ORDER BY
    REFF.CONST_NOM_FR,
    TRV.ALIM_CODE,
    TRV.CODE_CONFIANCE DESC;