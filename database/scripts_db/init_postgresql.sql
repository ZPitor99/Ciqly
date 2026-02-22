CREATE DATABASE ciqual
    WITH
    OWNER = ciqly_web
    ENCODING = 'UTF8'
    CONNECTION LIMIT = -1;
COMMENT ON DATABASE ciqual IS 'Base de données du Site Web Ciqly - https://github.com/ZPitor99/Ciqly';

CREATE TABLE groupe (
    alim_groupe_code CHAR(2),
    alim_groupe_fr VARCHAR(75),
    alim_groupe_eng VARCHAR(75),
    PRIMARY KEY (alim_groupe_code)
);
COMMENT ON TABLE groupe IS 'Table des groupes -> nom fr et en';

CREATE TABLE ssgroupe (
    alim_ssgroupe_code CHAR(4),
    alim_ssgroupe_fr VARCHAR(75),
    alim_ssgroupe_eng VARCHAR(75),
    PRIMARY KEY (alim_ssgroupe_code)
);
COMMENT ON TABLE ssgroupe IS 'Table des sous-groupes -> nom fr et en';


CREATE TABLE ssssgroupe (
    alim_ssssgroupe_code CHAR(6),
    alim_ssssgroupe_fr VARCHAR(75),
    alim_ssssgroupe_eng VARCHAR(75),
    PRIMARY KEY (alim_ssssgroupe_code)
);
COMMENT ON TABLE ssssgroupe IS  'Table des sous-sous-groupes -> nom fr et en';

CREATE TABLE hierarchie (
    alim_groupe_code CHAR(2),
    alim_ssgroupe_code CHAR(4),
    alim_ssssgroupe_code CHAR(6),
    PRIMARY KEY (alim_groupe_code, alim_ssgroupe_code, alim_ssssgroupe_code),
    CONSTRAINT fk_hierarchie_alim_groupe_code
        FOREIGN KEY (alim_groupe_code) REFERENCES groupe(alim_groupe_code)
            ON UPDATE CASCADE
            ON DELETE RESTRICT,
    CONSTRAINT fk_hierarchie_alim_ssgroupe_code
        FOREIGN KEY (alim_ssgroupe_code) REFERENCES ssgroupe(alim_ssgroupe_code)
            ON UPDATE CASCADE
            ON DELETE RESTRICT,
    CONSTRAINT fk_hierarchie_alim_ssssgroupe_code
        FOREIGN KEY (alim_ssssgroupe_code) REFERENCES ssssgroupe(alim_ssssgroupe_code)
            ON UPDATE CASCADE
            ON DELETE RESTRICT
);
COMMENT ON TABLE hierarchie IS 'Table des hierarchies des groupes';


CREATE TABLE aliments (
    alim_code INTEGER,
    alim_nom_fr VARCHAR(200) NOT NULL,
    alim_nom_eng VARCHAR(150),
    alim_nom_sci VARCHAR(100),
    facteur_jones DECIMAL(3,2),
    alim_grp_code CHAR(2),
    alim_ssgrp_code CHAR(4),
    alim_ssssgrp_code CHAR(6),
    PRIMARY KEY (alim_code),
    CONSTRAINT fk_aliments_alim_grp_code
        FOREIGN KEY (alim_grp_code, alim_ssgrp_code, alim_ssssgrp_code) REFERENCES hierarchie(alim_groupe_code, alim_ssgroupe_code, alim_ssssgroupe_code)
            ON UPDATE CASCADE
            ON DELETE RESTRICT
);
COMMENT ON TABLE aliments IS 'Table des aliments Ciqual';


CREATE TABLE constituants (
    const_code INTEGER,
    const_nom_fr VARCHAR(100) NOT NULL,
    const_nom_eng VARCHAR(100),
    code_INFOODS VARCHAR(10),
    PRIMARY KEY (const_code)
);
COMMENT ON TABLE constituants IS 'Table des constituants nutritionnels recherchés sur les aliments';


CREATE TABLE sources (
    code_source SMALLINT,
    ref_citation TEXT,
    PRIMARY KEY (code_source)
);
COMMENT ON TABLE sources IS 'Table des source de provenance des valeurs associé (aliment-constituant)';

-- TYPE ÉNUMÉRÉ DES DIFFÉRENTS TYPE DE TENEUR POSSIBLE
CREATE TYPE tn_type AS ENUM ('EXACTE', 'TRACE', 'INFÉRIEURE');

CREATE TABLE composition (
    alim_code INTEGER,
    const_code INTEGER,
    teneur_brute VARCHAR(10),
    teneur_type tn_type,
    teneur_valeur DECIMAL(14,7),
    teneur_min DECIMAL(12,6),
    teneur_max DECIMAL(14,7),
    code_confiance CHAR(1),
    source_code SMALLINT,
    PRIMARY KEY(alim_code, const_code),
    CONSTRAINT fk_composition_alim_code
        FOREIGN KEY (alim_code) REFERENCES aliments(alim_code)
            ON UPDATE RESTRICT
            ON DELETE RESTRICT,
    CONSTRAINT fk_composition_const_code
        FOREIGN KEY (const_code) REFERENCES constituants(const_code)
            ON UPDATE RESTRICT
            ON DELETE RESTRICT,
    CONSTRAINT fk_composition_source_code
        FOREIGN KEY (source_code) REFERENCES sources(code_source)
            ON UPDATE RESTRICT
            ON DELETE RESTRICT
);
COMMENT ON TABLE composition IS 'Table des composition liant aliment, constituant -> valeur';


CREATE TABLE alim_moyen (
    alim_moy_code INTEGER,
    alim_contrib_code INTEGER,
    pourcentage DECIMAL(5,2) CHECK ( pourcentage <= 100 ),
    PRIMARY KEY (alim_moy_code, alim_contrib_code),
    CONSTRAINT fk_alim_moyen_alim_moy_code
        FOREIGN KEY (alim_moy_code) REFERENCES aliments(alim_code)
            ON UPDATE RESTRICT
            ON DELETE RESTRICT,
    CONSTRAINT fk_alim_moyen_alim_contrib_code
        FOREIGN KEY (alim_contrib_code) REFERENCES aliments(alim_code)
            ON UPDATE RESTRICT
            ON DELETE RESTRICT
);
COMMENT ON TABLE alim_moyen IS 'Table des aliments moyens -> représentation d un aliment par rapport à un aliment moyen (générique)';
