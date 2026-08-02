CREATE OR REPLACE PROCEDURE ciqly_data.vider_table_prod()
LANGUAGE plpgsql
AS $$
BEGIN
    TRUNCATE TABLE ciqly_data.composition CASCADE ;
    TRUNCATE TABLE ciqly_data.alim_moyen CASCADE ;
    TRUNCATE TABLE ciqly_data.aliments CASCADE;
    TRUNCATE TABLE ciqly_data.constituants CASCADE ;
    TRUNCATE TABLE ciqly_data.sources CASCADE;
    TRUNCATE TABLE ciqly_data.hierarchie CASCADE;
    TRUNCATE TABLE ciqly_data.ssssgroupe CASCADE;
    TRUNCATE TABLE ciqly_data.ssgroupe CASCADE;
    TRUNCATE TABLE ciqly_data.groupe CASCADE;
END;
$$;

CREATE OR REPLACE FUNCTION ciqly_data.eval_confiance(concat_conf TEXT)
    RETURNS CHAR(1)
    LANGUAGE sql
    IMMUTABLE
AS $$
SELECT
    chr(64+round(avg(ascii(upper(lt_conf))-64))::INTEGER)
FROM
    unnest(string_to_array(concat_conf, null)) AS lt_conf
$$;
COMMENT ON FUNCTION ciqly_data.eval_confiance(concat_conf TEXT) is 'Calcul la moyenne des lettres de la chaine sous retour de la lettre arrondi';

CREATE OR REPLACE FUNCTION ciqly_data.ciqly_const_codes()
    RETURNS INTEGER[]
    LANGUAGE sql
    IMMUTABLE PARALLEL SAFE
AS $$
SELECT
    ARRAY[31000,40000,25000,333,400,10110,10120,10150,10190,10200,
        10260,10290,10300,10340,10530,51104,55100,52100,71010,
        53100,54101,32410,34100,75100]
$$;
COMMENT ON FUNCTION ciqly_data.ciqly_const_codes IS 'Code des constituants utiliser dans l assemblage ciqly';
