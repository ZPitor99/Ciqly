-- Utiliser le path absolue sur le serveur

SET ciqual.csv_data = 'database/python_import_script/csv/';
SET ciqual.csv_data = 'C:\Users\gabri\Documents\Ciqly\database\python_import_script\csv\';


DO $$
BEGIN

    CALL vider_table_prod();

    -- 1.GROUPE
    EXECUTE format(
        'COPY groupe (alim_groupe_code, alim_groupe_fr, alim_groupe_eng)' ||
        'FROM %L ' ||
        'WITH (' ||
            'FORMAT CSV, HEADER true, ' ||
            'NULL '''', ' ||
        'DELIMITER '',''' ||
        ');',
        current_setting('ciqual.csv_data') || 'groupe.csv'
    );

    INSERT INTO groupe(alim_groupe_code, alim_groupe_fr, alim_groupe_eng)
        VALUES ('00', null, null);
    COMMIT;

    -- 2.SSGROUPE
    EXECUTE format(
        'COPY ssgroupe (alim_ssgroupe_code, alim_ssgroupe_fr, alim_ssgroupe_eng)' ||
        'FROM %L ' ||
        'WITH (' ||
            'FORMAT CSV, HEADER true, ' ||
            'NULL '''', ' ||
        'DELIMITER '',''' ||
        ');',
        current_setting('ciqual.csv_data') || 'ssgroupe.csv'
    );

    -- 3.SSSSGROUPE
    EXECUTE format(
        'COPY ssssgroupe (alim_ssssgroupe_code, alim_ssssgroupe_fr, alim_ssssgroupe_eng)' ||
        'FROM %L ' ||
        'WITH (' ||
            'FORMAT CSV, HEADER true, ' ||
            'NULL '''', ' ||
        'DELIMITER '',''' ||
        ');',
        current_setting('ciqual.csv_data') || 'ssssgroupe.csv'
    );

    -- 4.HIERARCHIE
    EXECUTE format(
        'COPY hierarchie (alim_groupe_code, alim_ssgroupe_code, alim_ssssgroupe_code)' ||
        'FROM %L ' ||
        'WITH (' ||
            'FORMAT CSV, HEADER true, ' ||
            'NULL '''', ' ||
        'DELIMITER '',''' ||
        ');',
        current_setting('ciqual.csv_data') || 'hierarchie.csv'
    );

    INSERT INTO hierarchie(alim_groupe_code, alim_ssgroupe_code, alim_ssssgroupe_code)
        VALUES ('00','0000','000000');

    COMMIT;

    -- 5.ALIMENT
    EXECUTE format(
        'COPY aliments (alim_code, alim_nom_fr, alim_nom_eng, alim_nom_sci, facteur_jones, alim_grp_code, alim_ssgrp_code, alim_ssssgrp_code)' ||
        'FROM %L ' ||
        'WITH (' ||
            'FORMAT CSV, HEADER true, ' ||
            'NULL '''', ' ||
        'DELIMITER '',''' ||
        ');',
        current_setting('ciqual.csv_data') || 'aliments.csv'
    );

    -- 6.CONSTITUANT
    EXECUTE format(
        'COPY constituants (const_code, const_nom_fr, const_nom_eng, code_INFOODS)' ||
        'FROM %L ' ||
        'WITH (' ||
            'FORMAT CSV, HEADER true, ' ||
            'NULL '''', ' ||
        'DELIMITER '',''' ||
        ');',
        current_setting('ciqual.csv_data') || 'constituant.csv'
    );

    -- 7.SOURCE
    EXECUTE format(
        'COPY sources (code_source, ref_citation)' ||
        'FROM %L ' ||
        'WITH (' ||
            'FORMAT CSV, HEADER true, ' ||
            'NULL '''', ' ||
        'DELIMITER '',''' ||
        ');',
        current_setting('ciqual.csv_data') || 'sources.csv'
    );

    -- 8.COMPOSITION
    EXECUTE format(
        'COPY composition (alim_code, const_code, teneur_brute, teneur_type, teneur_valeur, teneur_min, teneur_max, code_confiance, source_code)' ||
        'FROM %L ' ||
        'WITH (' ||
            'FORMAT CSV, HEADER true, ' ||
            'NULL '''', ' ||
        'DELIMITER '',''' ||
        ');',
        current_setting('ciqual.csv_data') || 'composition.csv'
    );

END;
$$;


SELECT * FROM hierarchie h, groupe g, ssgroupe sg, ssssgroupe ssg WHERE h.alim_groupe_code = g.alim_groupe_code AND h.alim_ssgroupe_code = sg.alim_ssgroupe_code AND h.alim_ssssgroupe_code = ssg.alim_ssssgroupe_code;
