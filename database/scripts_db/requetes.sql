-- Selection des groupes avec sous-groupes associés
SELECT DISTINCT
            DENSE_RANK() OVER (
        ORDER BY
            HC.ALIM_GROUPE_CODE
        ) AS ID,
            HC.ALIM_GROUPE_CODE,
            HC.ALIM_SSGROUPE_CODE,
            COALESCE(SG.ALIM_SSGROUPE_FR, 'Non catégorisé') AS ALIM_SSGROUPE_FR,
            COALESCE(SG.ALIM_SSGROUPE_ENG, 'Uncategorized') AS ALIM_SSGROUPE_ENG

FROM
    HIERARCHIE HC
        INNER JOIN SSGROUPE SG ON HC.ALIM_SSGROUPE_CODE = SG.ALIM_SSGROUPE_CODE
ORDER BY
    id,
    HC.ALIM_SSGROUPE_CODE;

-- Selection des sous-groupes avec sous-sous-groupes associés
SELECT
    HC.ALIM_SSGROUPE_CODE,
    SSG.ALIM_SSSSGROUPE_CODE,
    COALESCE(SSG.ALIM_SSSSGROUPE_FR, 'Non catégorisé') AS ALIM_SSSSGROUPE_FR,
    COALESCE(SSG.ALIM_SSSSGROUPE_ENG, 'Uncategorized') AS ALIM_SSSSGROUPE_ENG

FROM
    HIERARCHIE HC
        INNER JOIN SSSSGROUPE SSG ON HC.ALIM_SSSSGROUPE_CODE = SSG.ALIM_SSSSGROUPE_CODE;


-- Selection infos pour un ensemble d'aliments
SELECT
    count(DISTINCT a.alim_code) AS nb_aliment,
    count(DISTINCT a.alim_grp_code) AS distinct_grp,
    eval_confiance(string_agg(c.code_confiance, '')) AS concat_conf
FROM
    composition c
        inner join aliments a on a.alim_code = c.alim_code
WHERE
    (const_code=31000 or const_code=40000 or const_code=25000 or const_code=333)
  AND c.alim_code in (8552, 25510, 20306, 13411);



-- Selection énergie, protéine, glucide, eau pour un groupe d'aliment pondéré par quantité (coefs)
SELECT
    cp.const_code AS t_cde,
    sum(cp.teneur_valeur*cf.coef) AS t_cf
FROM composition cp
         INNER JOIN
     unnest(
             ARRAY[8552, 25510, 20306, 13411],
             ARRAY[0.8, 2.2, 1, 1.25]
     ) AS cf(alim_code, coef) ON cp.alim_code = cf.alim_code
WHERE (cp.const_code=31000 or cp.const_code=40000 or cp.const_code=25000 or cp.const_code=333 or cp.const_code=400)
GROUP BY cp.const_code
ORDER BY cp.const_code;

-- Énergie, protéines, glucides, eau pour un groupe d'aliment pondéré par quantité (coefs) → PIVOT
SELECT
    round(sum(cp.teneur_valeur*cf.coef) FILTER (WHERE cp.const_code = 333))   AS "333",
    round(sum(cp.teneur_valeur*cf.coef) FILTER (WHERE cp.const_code = 400))   AS "400",
    round(sum(cp.teneur_valeur*cf.coef) FILTER (WHERE cp.const_code = 25000)) AS "25000",
    round(sum(cp.teneur_valeur*cf.coef) FILTER (WHERE cp.const_code = 31000)) AS "31000",
    round(sum(cp.teneur_valeur*cf.coef) FILTER (WHERE cp.const_code = 40000)) AS "40000"
FROM composition cp
         INNER JOIN
     unnest(
             ARRAY[8552, 25510, 20306, 13411],
             ARRAY[0.8, 2.2, 1, 1.25]
     ) AS cf(alim_code, coef) ON cp.alim_code = cf.alim_code
WHERE cp.const_code IN (31000, 40000, 25000, 333, 400);