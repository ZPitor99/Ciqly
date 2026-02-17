from lxml import etree
from tools_script_insert import get_text, ecrire_fichier_csv_liste_dict

xml = "../../dataverse_files/alim_2025_11_03.xml"


# Charger le fichier XML
tree = etree.parse(xml)
root = tree.getroot()

cpt = 0
cpt_verif = 0
L = []
for compo in root.findall("ALIM"):

    D_src = {}

    alim_code = get_text(compo, "alim_code")
    alim_nom_fr = get_text(compo, "alim_nom_fr")
    alim_nom_eng = get_text(compo, "alim_nom_eng")
    alim_nom_sci = get_text(compo, "alim_nom_sci")
    facteur_Jones = get_text(compo, "facteur_Jones")
    alim_grp_code = get_text(compo, "alim_grp_code")
    alim_ssgrp_code = get_text(compo, "alim_ssgrp_code")
    alim_ssssgrp_code = get_text(compo, "alim_ssssgrp_code")

    alim_code = int(alim_code)
    facteur_Jones = float(facteur_Jones.replace(",", ".").strip()) if facteur_Jones else None

    assert isinstance(alim_code, int)
    assert isinstance(facteur_Jones, float) or facteur_Jones is None
    assert alim_nom_fr is not None

    D_src["alim_code"] = alim_code
    D_src["alim_nom_fr"] = alim_nom_fr
    D_src["alim_nom_eng"] = alim_nom_eng
    D_src["alim_nom_sci"] = alim_nom_sci
    D_src["facteur_Jones"] = facteur_Jones
    D_src["alim_grp_code"] = alim_grp_code
    D_src["alim_ssgrp_code"] = alim_ssgrp_code
    D_src["alim_ssssgrp_code"] = alim_ssssgrp_code

    L.append(D_src)
    cpt += 1

for elem in L:
    print(elem)
    cpt_verif += 1

# cpt et cpt_verif afin de contrôler si un code du dictionnaire n'as pas été réécrit
print("==> Vérification nombre: ", cpt == cpt_verif)

#Générer csv
chemin = "csv/aliments.csv"
ecrire_fichier_csv_liste_dict(chemin, L)