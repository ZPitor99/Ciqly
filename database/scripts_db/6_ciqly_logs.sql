CREATE SCHEMA ciqly_logs;

set search_path = ciqly_data, ciqly_logs, "$user", public;

CREATE TABLE ciqly_logs.journal_sess (
	code_sess		BIGINT GENERATED ALWAYS AS IDENTITY,
    session_id      VARCHAR(64),
    dt_cr      		TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    dt_dr_up    	TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	type_nav		VARCHAR(20),
    type_mat     	VARCHAR(20),
	PRIMARY KEY (code_sess),
	CONSTRAINT uq_journal_sess_session_id
		UNIQUE (session_id)
);
COMMENT ON TABLE ciqly_logs.journal_sess IS 'Table des session utilisateurs ciqly';


CREATE TYPE ciqly_logs.nature_act AS ENUM ('ajout', 'suppr', 'haut', 'bas', 'tare', 'asbl');

CREATE TABLE ciqly_logs.journal_ress (
	id_jress BIGINT GENERATED ALWAYS AS IDENTITY,
	session_id VARCHAR(64),
	dt_cons TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	code_page SMALLINT,
	nat_act ciqly_logs.nature_act,
	alim_code INTEGER,
	txt_rech text,
	PRIMARY KEY (id_jress),
	CONSTRAINT fk_journal_ress_session_id
		FOREIGN KEY (session_id) REFERENCES ciqly_logs.journal_sess (session_id)
			ON UPDATE RESTRICT
			ON DELETE CASCADE,
	CONSTRAINT fk_journal_ress_alim_code
		FOREIGN KEY (alim_code) REFERENCES ciqly_data.aliments
			ON UPDATE CASCADE
			ON DELETE SET NULL
);
COMMENT ON TABLE ciqly_logs.journal_ress IS 'Table des ressources consultés (pages et actions)';


CREATE TABLE ciqly_logs.journal_asbl (
	id_jress BIGINT,
	alim_pos_pan SMALLINT,
	alim_code INTEGER,
	qte SMALLINT,
	PRIMARY KEY (id_jress, alim_pos_pan),
	CONSTRAINT fk_journal_asbl_id_jress
		FOREIGN KEY (id_jress) REFERENCES ciqly_logs.journal_ress (id_jress)
			ON UPDATE RESTRICT
			ON DELETE CASCADE,
	CONSTRAINT check_journal_asbl_alim_pos_pan CHECK (alim_pos_pan >= 0),
	CONSTRAINT fk_journal_asbl_alim_code
		FOREIGN KEY (alim_code) REFERENCES ciqly_data.aliments
			ON UPDATE CASCADE
			ON DELETE SET NULL,
	CONSTRAINT check_journal_asbl_qte CHECK (qte >= 0)
);
COMMENT ON TABLE ciqly_logs.journal_asbl IS 'Table des aliments assemblés lors action assemblage';