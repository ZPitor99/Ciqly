from lxml import etree
from tools_script_insert import get_text

xml = "../../dataverse_files/const_2025_11_03.xml"


# Charger le fichier XML
tree = etree.parse(xml)
root = tree.getroot()

D_src = {}
cpt = 0
cpt_verif = 0
for compo in root.findall("CONST"):

    const_code = get_text(compo, "const_code")
    const_nom_fr = get_text(compo, "const_nom_fr")
    const_nom_eng = get_text(compo, "const_nom_eng")
    code_INFOODS = get_text(compo, "code_INFOODS")

    const_code = int(const_code)

    assert const_nom_fr is not None

    D_src[const_code] = (const_nom_fr, const_nom_eng, code_INFOODS)
    cpt += 1


for elem in D_src.items():
    print(elem)
    cpt_verif += 1

# cpt et cpt_verif afin de contrôler si un code du dictionnaire n'as pas été réécrit
print("==> Vérification nombre: ", cpt == cpt_verif)

