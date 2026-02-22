from lxml import etree
from tools_script_insert import get_text, normalise_teneur, ecrire_fichier_csv_liste_dict

xml = "../../dataverse_files/compo_2025_11_03.xml"


# Charger le fichier XML
tree = etree.parse(xml)
root = tree.getroot()

L = []
cpt = 0
cpt_verif = 0
for compo in root.findall("COMPO"):
    D_src = {}

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
    if teneur_brute is None:
        print(cpt)
        assert teneur_type is None and teneur_valeur is None and min_teneur is None and max_teneur is None


    D_src['alim_code'] = alim_code
    D_src['const_code'] = const_code
    D_src['teneur_brute'] = teneur_brute
    D_src['teneur_type'] = teneur_type
    D_src['teneur_valeur'] = teneur_valeur
    D_src['min_teneur'] = min_teneur
    D_src['max_teneur'] = max_teneur
    D_src['code_confiance'] = code_confiance
    D_src['source_code'] = source_code
    cpt += 1
    L.append(D_src)


for elem in L:
    print(elem)
    cpt_verif += 1

# cpt et cpt_verif afin de contrôler si un code du dictionnaire n'as pas été réécrit
print("==> Vérification nombre: ", cpt == cpt_verif)

#Générer csv
chemin = "csv/composition.csv"
ecrire_fichier_csv_liste_dict(chemin, L)