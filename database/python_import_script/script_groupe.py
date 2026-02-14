from lxml import etree

xml = "../../dataverse_files/alim_grp_2025_11_03.xml"


def get_text(element_name):
    el = compo.find(element_name)
    if el is not None and el.text:
        rt = el.text.strip()
        return rt if rt != "-" else None
    return None

# Charger le fichier XML
tree = etree.parse(xml)
root = tree.getroot()

D_groupe = {}
D_ssgroupe = {}
D_ssssgrp_code = {}
H = []
for compo in root.findall("ALIM_GRP"):

    alim_grp_code = get_text("alim_grp_code")
    alim_grp_nom_fr = get_text("alim_grp_nom_fr")
    alim_grp_nom_eng = get_text("alim_grp_nom_eng")
    alim_ssgrp_code = get_text("alim_ssgrp_code")
    alim_ssgrp_nom_fr = get_text("alim_ssgrp_nom_fr")
    alim_ssgrp_nom_eng = get_text("alim_ssgrp_nom_eng")
    alim_ssssgrp_code = get_text("alim_ssssgrp_code")
    alim_ssssgrp_nom_fr = get_text("alim_ssssgrp_nom_fr")
    alim_ssssgrp_nom_eng = get_text("alim_ssssgrp_nom_eng")

    H.append((alim_grp_code,alim_ssgrp_code,alim_ssssgrp_code))
    D_groupe[alim_grp_code] = (alim_grp_nom_fr,alim_grp_nom_eng)
    D_ssgroupe[alim_ssgrp_code] = (alim_ssgrp_nom_fr,alim_ssgrp_nom_eng)
    D_ssssgrp_code[alim_ssssgrp_code] = (alim_ssssgrp_nom_fr,alim_ssssgrp_nom_eng)

for elem in H:
    print(elem)
print("----------")
for elem in D_groupe.items():
    print(elem)
print("----------")
for elem in D_ssgroupe.items():
    print(elem)
print("----------")
for elem in D_ssssgrp_code.items():
    print(elem)
