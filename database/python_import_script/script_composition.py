from lxml import etree
from tools_script_insert import get_text, normalise_teneur

xml = "../../dataverse_files/compo_2025_11_03.xml"


# Charger le fichier XML
tree = etree.parse(xml)
root = tree.getroot()

D_src = {}
cpt = 0
cpt_verif = 0
for compo in root.findall("COMPO"):

    alim_code = get_text(compo, "alim_code")
    const_code = get_text(compo, "const_code")
    teneur_brute = get_text(compo, "teneur")
    min_teneur = get_text(compo, "min")
    max_teneur = get_text(compo, "max")
    code_confiance = get_text(compo, "code_confiance")
    source_code = get_text(compo, "source_code")

    alim_code = int(alim_code)
    const_code = int(const_code)
    teneur_type, teneur_valeur = normalise_teneur(teneur_brute)
    min_teneur = float(min_teneur.replace(",", ".")) if min_teneur else None
    max_teneur = float(max_teneur.replace(",", ".")) if max_teneur else None
    source_code = int(source_code) if source_code else None

    assert teneur_type != "ATT"
    assert isinstance(alim_code, int)
    assert isinstance(const_code, int)
    assert isinstance(source_code, int) or source_code is None

    D_src[(alim_code,const_code)] = (teneur_brute, teneur_type, teneur_valeur, min_teneur, max_teneur, code_confiance, source_code)
    cpt += 1


for elem in D_src.items():
    print(elem)
    cpt_verif += 1

# cpt et cpt_verif afin de contrôler si un code du dictionnaire n'as pas été réécrit
print("==> Vérification nombre: ", cpt == cpt_verif)

