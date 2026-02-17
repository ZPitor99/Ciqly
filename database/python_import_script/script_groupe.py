from lxml import etree
from tools_script_insert import get_text, ecrire_fichier_csv_liste_dict

xml = "../../dataverse_files/alim_grp_2025_11_03.xml"

# Charger le fichier XML
tree = etree.parse(xml)
root = tree.getroot()

D_groupe = {}
D_ssgroupe = {}
D_ssssgroupe = {}
H = []
LG = []
LSG = []
LSSG = []
cpt = 0
cpt_verif = 0
for compo in root.findall("ALIM_GRP"):

    D_H = {}
    alim_grp_code = get_text(compo, "alim_grp_code")
    alim_grp_nom_fr = get_text(compo,"alim_grp_nom_fr")
    alim_grp_nom_eng = get_text(compo, "alim_grp_nom_eng")
    alim_ssgrp_code = get_text(compo, "alim_ssgrp_code")
    alim_ssgrp_nom_fr = get_text(compo, "alim_ssgrp_nom_fr")
    alim_ssgrp_nom_eng = get_text(compo, "alim_ssgrp_nom_eng")
    alim_ssssgrp_code = get_text(compo, "alim_ssssgrp_code")
    alim_ssssgrp_nom_fr = get_text(compo, "alim_ssssgrp_nom_fr")
    alim_ssssgrp_nom_eng = get_text(compo, "alim_ssssgrp_nom_eng")

    #On garde cette structure pour éviter les doublons
    D_groupe[alim_grp_code] = (alim_grp_nom_fr, alim_grp_nom_eng)
    D_ssgroupe[alim_ssgrp_code] = (alim_ssgrp_nom_fr, alim_ssgrp_nom_eng)
    D_ssssgroupe[alim_ssssgrp_code] = (alim_ssssgrp_nom_fr, alim_ssssgrp_nom_eng)

    D_H["alim_groupe_code"] = alim_grp_code
    D_H["alim_ssgroupe_code"] = alim_ssgrp_code
    D_H["alim_ssssgroupe_code"] = alim_ssssgrp_code

    H.append(D_H)
    cpt += 1

# On parcourt les dictionnaires pour transformer le format afin d'exporter via la méthode en csv
for k, v in D_groupe.items():
    LG.append({
        "alim_groupe_code" : k,
        "alim_groupe_fr" : v[0],
        "alim_groupe_eng" : v[1]
    })
for k, v in D_ssgroupe.items():
    LSG.append({
        "alim_ssgroupe_code" : k,
        "alim_ssgroupe_fr" : v[0],
        "alim_ssgroupe_eng" : v[1]
    })
for k, v in D_ssssgroupe.items():
    LSSG.append({
        "alim_ssssgroupe_code" : k,
        "alim_ssssgroupe_fr" : v[0],
        "alim_ssssgroupe_eng" : v[1]
    })

for elem in H:
    print(elem)
    cpt_verif += 1
print("----------")
for elem in LG:
    print(elem)
print("----------")
for elem in LSG:
    print(elem)
print("----------")
for elem in LSSG:
    print(elem)

# cpt et cpt_verif afin de contrôler si un code du dictionnaire n'as pas été réécrit
print("==> Vérification nombre: ", cpt == cpt_verif)

#Générer csv
chemin1 = "csv/hierarchie.csv"
ecrire_fichier_csv_liste_dict(chemin1, H)
chemin2 = "csv/groupe.csv"
ecrire_fichier_csv_liste_dict(chemin2, LG)
chemin3 = "csv/ssgroupe.csv"
ecrire_fichier_csv_liste_dict(chemin3, LSG)
chemin4 = "csv/ssssgroupe.csv"
ecrire_fichier_csv_liste_dict(chemin4, LSSG)