from lxml import etree
from tools_script_insert import get_text

xml = "../../dataverse_files/alim_grp_2025_11_03.xml"

# Charger le fichier XML
tree = etree.parse(xml)
root = tree.getroot()

D_groupe = {}
D_ssgroupe = {}
D_ssssgrp_code = {}
H = []
cpt = 0
cpt_verif = 0
for compo in root.findall("ALIM_GRP"):

    alim_grp_code = get_text(compo, "alim_grp_code")
    alim_grp_nom_fr = get_text(compo,"alim_grp_nom_fr")
    alim_grp_nom_eng = get_text(compo, "alim_grp_nom_eng")
    alim_ssgrp_code = get_text(compo, "alim_ssgrp_code")
    alim_ssgrp_nom_fr = get_text(compo, "alim_ssgrp_nom_fr")
    alim_ssgrp_nom_eng = get_text(compo, "alim_ssgrp_nom_eng")
    alim_ssssgrp_code = get_text(compo, "alim_ssssgrp_code")
    alim_ssssgrp_nom_fr = get_text(compo, "alim_ssssgrp_nom_fr")
    alim_ssssgrp_nom_eng = get_text(compo, "alim_ssssgrp_nom_eng")

    H.append((alim_grp_code,alim_ssgrp_code,alim_ssssgrp_code))
    D_groupe[alim_grp_code] = (alim_grp_nom_fr,alim_grp_nom_eng)
    D_ssgroupe[alim_ssgrp_code] = (alim_ssgrp_nom_fr,alim_ssgrp_nom_eng)
    D_ssssgrp_code[alim_ssssgrp_code] = (alim_ssssgrp_nom_fr,alim_ssssgrp_nom_eng)
    cpt += 1

for elem in H:
    print(elem)
    cpt_verif += 1
print("----------")
for elem in D_groupe.items():
    print(elem)
print("----------")
for elem in D_ssgroupe.items():
    print(elem)
print("----------")
for elem in D_ssssgrp_code.items():
    print(elem)

# cpt et cpt_verif afin de contrôler si un code du dictionnaire n'as pas été réécrit
print("==> Vérification nombre: ", cpt == cpt_verif)
