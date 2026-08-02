CREATE TABLE ciqly_data.ciqly_cache_assemblage (
    nature      CHAR(1)     NOT NULL,
    const_code  INTEGER,
    nom         VARCHAR(25) NOT NULL,
    type_besoin VARCHAR(5),
    unite       VARCHAR(6),
    val_hom     VARCHAR(6),
    val_fem     VARCHAR(6),
    val_moy     VARCHAR(6),
    comm        TEXT,
    PRIMARY KEY (const_code)
);
COMMENT ON TABLE ciqly_data.ciqly_cache_assemblage IS 'Table de cahe pour le TDB d''assemblage';

INSERT INTO ciqly_data.ciqly_cache_assemblage (nature, const_code, nom, type_besoin, unite, val_hom, val_fem, val_moy, comm)
VALUES ('G', 333, 'Énergie', NULL, 'kcal', NULL, NULL, '2000', 'N x facteur Jones, avec fibres (kcal/100 g)'),
       ('E', 400, 'Eau', NULL, 'g', NULL, NULL, '1000', NULL),
       ('M', 10110, 'Sodium', 'AS', 'mg', '1500', '1500', '1500',
        'Moyenne du BNM à défaut de l''AS des hommes et femmes de + 18ans.'),
       ('M', 10120, 'Magnésium', 'AS', 'mg', '380', '300', '340',
        'Moyenne du BNM à défaut de l''AS des hommes et femmes de + 18ans.'),
       ('M', 10150, 'Phosphore', 'AS', 'mg', '550', '550', '550',
        'Moyenne du BNM à défaut de l''AS des hommes et femmes de + 18ans.'),
       ('M', 10190, 'Potassium', 'AS', 'mg', '3500', '3500', '3500',
        'Moyenne du BNM à défaut de l''AS des hommes et femmes de + 18ans.'),
       ('M', 10200, 'Calcium', 'BNM', 'mg', '750', '750', '750',
        'Moyenne du BNM à défaut de l''AS des hommes et femmes de + 24ans.'),
       ('M', 10260, 'Fer', 'BNM', 'mg', '6', '7', '6,5',
        'Moyenne du BNM à défaut de l''AS des hommes et femmes de + 18ans.'),
       ('M', 10290, 'Cuivre', 'AS', 'mg', '1,9', '1,5', '1,7',
        'Moyenne du BNM à défaut de l''AS des hommes et femmes de + 18ans.'),
       ('M', 10300, 'Zinc', 'BNM', 'µg', '9,3', '7,6', '8,45',
        'Moyenne du BNM à défaut de l''AS des hommes et femmes de + 18ans. Sur une base d''un apports en phytates (600 mg/j)'),
       ('M', 10340, 'Sélénium', 'AS', 'mg', '70', '70', '70',
        'Moyenne du BNM à défaut de l''AS des hommes et femmes de + 18ans.'),
       ('M', 10530, 'Iode', 'AS', 'µg', '150', '150', '150',
        'Moyenne du BNM à défaut de l''AS des hommes et femmes de + 18ans.'),
       ('G', 25000, 'Protéines', NULL, 'g', NULL, NULL, '75',
        'Entre 10% et 20 % de l''apport énergétique quotidien, en considérant un apport de référence de 2 000 kcal par jour.'),
       ('G', 31000, 'Glucides', NULL, 'g', NULL, NULL, '265',
        'Entre 50% et 55 % de l''apport énergétique quotidien, en considérant un apport de référence de 2 000 kcal par jour.'),
       ('N', 32410, 'Lactose', NULL, 'g', NULL, NULL, NULL,
        'en g - Définition : Sucre contenu dans le lait. (Le Robert - Larousse)'),
       ('N', 34100, 'Fibres alimentaires', NULL, 'g', NULL, NULL, NULL,
        'en g - Définition : Substance résiduelle d''origine végétale non digérée par les enzymes du tube digestif. (Larousse)'),
       ('G', 40000, 'Lipides', NULL, 'g', NULL, NULL, '85',
        'Entre 35% et 40 % de l''apport énergétique quotidien, en considérant un apport de référence de 2 000 kcal par jour.'),
       ('V', 51104, 'Activité vitaminique A', 'BNM', 'µg', '580', '490', '535',
        'Moyenne du BNM à défaut de l''AS des hommes et femmes de + 18ans. Equivalents rétinol des rétinols + β-carotènes. (IOM 2001)'),
       ('V', 52100, 'Vitamine D', 'AS', 'µg', '15', '15', '15',
        'Moyenne du BNM à défaut de l''AS des hommes et femmes de + 18ans. Les vitamine D2 + D3.'),
       ('V', 54101, 'Vitamine K1', 'AS', 'µg', '79', '79', '79',
        'Moyenne du BNM à défaut de l''AS des hommes et femmes de + 18ans.'),
       ('V', 55100, 'Vitamine C', 'BNM', 'mg', '90', '90', '90',
        'Moyenne du BNM à défaut de l''AS des hommes et femmes de + 18ans.'),
       ('V', 71010, 'Vitamine E', 'AS', 'mg', '10', '9', '9,5',
        'Moyenne du BNM à défaut de l''AS des hommes et femmes de + 18ans. Les Alpha-tocophérol (EFSA 2015), sinon Vitamine E sans précision'),
       ('N', 75100, 'Cholestérol', NULL, 'mg', NULL, NULL, NULL,
        'en mg - Définition : Substance lipidique, essentiellement synthétisée par le foie à partir d''une autre substance. (Le Robert) - Dans l’alimentation, le cholestérol est exclusivement apporté par les produits animaux. (ANSES)');




CREATE MATERIALIZED VIEW ciqly_data.MVW_ciqly_const_assembl_null AS (
    SELECT
        cp.alim_code AS assbl_code,
        a.alim_nom_fr AS assbl_alim,
        replace(split_part(ct.const_nom_fr, '(', 1), ',', '' ) AS assbl_nom
    FROM ciqly_data.composition cp
        inner join ciqly_data.constituants ct on cp.const_code = ct.const_code
        inner join ciqly_data.aliments a on cp.alim_code = a.alim_code
    WHERE cp.teneur_valeur is null
      and cp.const_code = ANY(ciqly_data.ciqly_const_codes())
    )
WITH  NO  DATA;
REFRESH MATERIALIZED VIEW ciqly_data.MVW_ciqly_const_assembl_null;
COMMENT ON MATERIALIZED VIEW ciqly_data.MVW_ciqly_const_assembl_null is 'Aliments avec des constituant null';
CREATE INDEX idx_MVW_ciqly_const_assembl_null_alim_code ON ciqly_data.MVW_ciqly_const_assembl_null(assbl_code);
-- CONCURRENTLY => INDEX UNIQUE

CREATE OR REPLACE FUNCTION ciqly_data.ciqly_const_assembl_null(par_code INTEGER[])
RETURNS TEXT
LANGUAGE plpgsql
AS $$
DECLARE
    curs_const_assbl CURSOR FOR SELECT assbl_alim, assbl_nom
                                FROM ciqly_data.MVW_ciqly_const_assembl_null
                                WHERE assbl_code = ANY(par_code)
                                ORDER BY assbl_code;
    v_alim ciqly_data.MVW_ciqly_const_assembl_null.assbl_alim%TYPE;
    v_nom ciqly_data.MVW_ciqly_const_assembl_null.assbl_nom%TYPE;
    v_alim_courant ciqly_data.MVW_ciqly_const_assembl_null.assbl_alim%TYPE;
    v_ligne TEXT := '';
    v_result TEXT := '';
BEGIN

    OPEN curs_const_assbl;
    LOOP
        FETCH curs_const_assbl INTO v_alim, v_nom;
        EXIT WHEN NOT FOUND;

        IF v_alim_courant IS DISTINCT FROM v_alim THEN

            IF v_alim_courant IS NOT NULL THEN
                v_result := v_result || trim(v_ligne) || E'\n';
            END IF;
            v_alim_courant := v_alim;
            v_ligne := '• ' || v_alim || ' : ' || v_nom;
        ELSE
            v_ligne := trim(v_ligne) || ', ' || v_nom;
        END IF;
    END LOOP;
    CLOSE curs_const_assbl;

    IF v_ligne <> '' THEN
        v_result := v_result || v_ligne;
    END IF;

    IF v_result <> '' THEN
        RETURN trim(v_result);
    ELSE
        RETURN 'Tout les macros-nutriments sont définies pour les aliments sélectionnés';
    END IF;

END;
$$;
COMMENT ON FUNCTION ciqly_data.ciqly_const_assembl_null IS 'Générer la liste des constituants null pour chaque aliment en paramètre';