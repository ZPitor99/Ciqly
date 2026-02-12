DROP DATABASE IF EXISTS ciqual;
CREATE DATABASE ciqual;

-- CREATION DE UTILISATEUR CIQUAL DANS FICHIER SQL DEDIÉ

CREATE TABLE `groupe` (
    alim_groupe_code CHAR(2),
    alim_groupe_fr VARCHAR(75),
    alim_groupe_eng VARCHAR(75),
    PRIMARY KEY (alim_groupe_code)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
COMMENT = 'Table des groupes -> nom fr et en';

CREATE TABLE `ssgroupe` (
    alim_ssgroupe_code CHAR(4),
    alim_ssgroupe_fr VARCHAR(75),
    alim_ssgroupe_eng VARCHAR(75),
    PRIMARY KEY (alim_ssgroupe_code)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
COMMENT = 'Table des sous-groupes -> nom fr et en';


CREATE TABLE `ssssgroupe` (
    alim_ssssgroupe_code CHAR(6),
    alim_ssssgroupe_fr VARCHAR(75),
    alim_ssssgroupe_eng VARCHAR(75),
    PRIMARY KEY (alim_ssssgroupe_code)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
COMMENT = 'Table des sous-sous-groupes -> nom fr et en';


CREATE TABLE `aliments` (
    alim_code MEDIUMINT,
    alim_nom_fr VARCHAR(200) NOT NULL,
    alim_nom_eng VARCHAR(150),
    alim_nom_sci VARCHAR(100),
    facteur_jones DECIMAL(3,2),
    alim_grp_code CHAR(2),
    alim_ssgrp_code CHAR(4),
    alim_ssssgrp_code CHAR(6),
    PRIMARY KEY (alim_code),
    INDEX idx_aliments_alim_nom_fr (alim_nom_fr),
    INDEX idx_aliments_alim_grp_code (alim_grp_code),
    INDEX idx_aliments_alim_ssgrp_code (alim_ssgrp_code),
    INDEX idx_aliments_alim_ssssgrp_code (alim_ssssgrp_code),
    CONSTRAINT fk_aliments_alim_grp_code
        FOREIGN KEY (alim_grp_code) REFERENCES groupe(alim_groupe_code)
            ON UPDATE CASCADE
            ON DELETE RESTRICT,
    CONSTRAINT fk_aliments_alim_ssgrp_code
        FOREIGN KEY (alim_ssgrp_code) REFERENCES ssgroupe(alim_ssgroupe_code)
            ON UPDATE CASCADE
            ON DELETE RESTRICT,
    CONSTRAINT fk_aliments_alim_ssssgrp_code
        FOREIGN KEY (alim_ssssgrp_code) REFERENCES ssssgroupe(alim_ssssgroupe_code)
            ON UPDATE CASCADE
            ON DELETE RESTRICT
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
COMMENT = 'Table des aliments Ciqual';


CREATE TABLE constituants (
    const_code MEDIUMINT,
    const_nom_fr VARCHAR(100) NOT NULL,
    const_nom_eng VARCHAR(100),
    nom_infoods VARCHAR(10),
    PRIMARY KEY (const_code)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
COMMENT = 'Table des constituants nutritionnels recherchés sur les aliments';


CREATE TABLE `sources` (
    code_source SMALLINT,
    ref_citation TEXT,
    PRIMARY KEY (code_source)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
COMMENT = 'Table des source de provenance des valeurs associé (aliment-constituant)';

-- AVEC PRISE EN COMPTE DES DONNEES → MODIFICATION DU SCHEMA (TRACE ET <)

CREATE TABLE `composition` (
    alim_code MEDIUMINT,
    const_code MEDIUMINT,
    teneur_brute VARCHAR(10),
    teneur_type ENUM('EXACTE', 'TRACE', 'INFÉRIEURE'),
    teneur_valeur SMALLINT,
    teneur_min DECIMAL(12,6),
    teneur_max DECIMAL(14,7),
    code_confiance CHAR(1),
    source_code SMALLINT,
    PRIMARY KEY(alim_code, const_code),
    INDEX idx_composition_alim_code (alim_code),
    INDEX idx_composition_const_code (const_code),
    INDEX idx_composition_source_code (source_code),
    INDEX idx_composition_teneur_type (teneur_type),
    INDEX idx_composition_teneur_valeur (teneur_valeur),
    INDEX idx_composition_teneur_type_valeur (teneur_type, teneur_valeur),
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
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
COMMENT = 'Table des composition liant aliment, constituant -> valeur';


CREATE TABLE `alim_moyen` (
    alim_moy_code MEDIUMINT,
    alim_contrib_code MEDIUMINT,
    pourcentage DECIMAL(5,2) CHECK ( pourcentage <= 100 ),
    PRIMARY KEY (alim_moy_code, alim_contrib_code),
    INDEX idx_alim_moyen_alim_moy_code (alim_moy_code),
    INDEX idx_alim_moyen_alim_contrib_code (alim_contrib_code),
    INDEX idx_alim_moyen_pourcentage (pourcentage),
    CONSTRAINT fk_alim_moyen_alim_moy_code
        FOREIGN KEY (alim_moy_code) REFERENCES aliments(alim_code)
            ON UPDATE RESTRICT
            ON DELETE RESTRICT,
    CONSTRAINT fk_alim_moyen_alim_contrib_code
        FOREIGN KEY (alim_contrib_code) REFERENCES aliments(alim_code)
            ON UPDATE RESTRICT
            ON DELETE RESTRICT
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
    COMMENT = 'Table des aliments moyens -> représentation d\'un aliment par rapport à un aliment moyen (générique)';