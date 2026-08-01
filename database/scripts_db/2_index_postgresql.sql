-- INDEX

CREATE INDEX idx_hierarchie_alim_groupe_code ON ciqly_data.hierarchie(alim_groupe_code);
CREATE INDEX idx_hierarchie_alim_ssgroupe_code ON ciqly_data.hierarchie(alim_ssgroupe_code);
CREATE INDEX idx_hierarchie_alim_ssssgroupe_code ON ciqly_data.hierarchie(alim_ssssgroupe_code);

CREATE INDEX idx_aliments_alim_nom_fr ON ciqly_data.aliments(alim_nom_fr);
CREATE INDEX idx_aliments_hierarchie ON ciqly_data.aliments(alim_grp_code, alim_ssgrp_code, alim_ssssgrp_code);

CREATE INDEX idx_composition_alim_code ON ciqly_data.composition(alim_code);
CREATE INDEX idx_composition_const_code ON ciqly_data.composition(const_code);
CREATE INDEX idx_composition_source_code ON ciqly_data.composition(source_code);
CREATE INDEX idx_composition_alim_const_codes_covering_teneur_v ON ciqly_data.composition (alim_code, const_code) INCLUDE (teneur_valeur);

CREATE INDEX idx_alim_moyen_alim_moy_code ON ciqly_data.alim_moyen(alim_moy_code);
CREATE INDEX idx_alim_moyen_alim_contrib_code ON ciqly_data.alim_moyen(alim_contrib_code);
CREATE INDEX idx_alim_moyen_pourcentage ON ciqly_data.alim_moyen(pourcentage);