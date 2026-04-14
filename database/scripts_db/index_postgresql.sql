-- INDEX

CREATE INDEX idx_hierarchie_alim_groupe_code ON hierarchie(alim_groupe_code);
CREATE INDEX idx_hierarchie_alim_ssgroupe_code ON hierarchie(alim_ssgroupe_code);
CREATE INDEX idx_hierarchie_alim_ssssgroupe_code ON hierarchie(alim_ssssgroupe_code);

CREATE INDEX idx_aliments_alim_nom_fr ON aliments(alim_nom_fr);
CREATE INDEX idx_aliments_hierarchie ON aliments(alim_grp_code, alim_ssgrp_code, alim_ssssgrp_code);

CREATE INDEX idx_composition_alim_code ON composition(alim_code);
CREATE INDEX idx_composition_const_code ON composition(const_code);
CREATE INDEX idx_composition_source_code ON composition(source_code);
CREATE INDEX idx_composition_teneur_type_valeur ON composition(teneur_type, teneur_valeur);
CREATE INDEX idx_composition_teneur_valeur ON composition(teneur_valeur NULLS FIRST);

CREATE INDEX idx_alim_moyen_alim_moy_code ON alim_moyen(alim_moy_code);
CREATE INDEX idx_alim_moyen_alim_contrib_code ON alim_moyen(alim_contrib_code);
CREATE INDEX idx_alim_moyen_pourcentage ON alim_moyen(pourcentage);