CREATE OR REPLACE PROCEDURE vider_table_prod()
LANGUAGE PLPGSQL
AS $$
BEGIN
    TRUNCATE TABLE composition CASCADE ;
    TRUNCATE TABLE alim_moyen CASCADE ;
    TRUNCATE TABLE aliments CASCADE;
    TRUNCATE TABLE constituants CASCADE ;
    TRUNCATE TABLE sources CASCADE;
    TRUNCATE TABLE hierarchie CASCADE;
    TRUNCATE TABLE ssssgroupe CASCADE;
    TRUNCATE TABLE ssgroupe CASCADE;
    TRUNCATE TABLE groupe CASCADE;
END;
$$;

CREATE OR REPLACE FUNCTION eval_confiance(concat_conf TEXT)
    RETURNS CHAR(1)
    LANGUAGE sql
    IMMUTABLE
AS $$
SELECT
    chr(64+round(avg(ascii(upper(lt_conf))-64))::INTEGER)
FROM
    unnest(string_to_array(concat_conf, null)) AS lt_conf
$$;
COMMENT ON FUNCTION eval_confiance(concat_conf TEXT) is 'Calcul la moyenne des lettres de la chaine sous retour de la lettre arrondi';
