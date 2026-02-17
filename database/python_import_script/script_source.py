from lxml import etree
from tools_script_insert import get_text, ecrire_fichier_csv_liste_dict

xml = "../../dataverse_files/sources_2025_11_03.xml"


# Charger le fichier XML
tree = etree.parse(xml)
root = tree.getroot()

L = []
cpt = 0
cpt_verif = 0
for compo in root.findall("SOURCES"):
    D_src = {}

    source_code = get_text(compo, "source_code")
    ref_citation = get_text(compo, "ref_citation")

    source_code = int(source_code)

    D_src["source_code"] = source_code
    D_src["ref_citation"] = ref_citation
    cpt += 1
    L.append(D_src)


for elem in L:
    print(elem)
    cpt_verif = cpt_verif+1

# cpt et cpt_verif afin de contrôler si un code du dictionnaire n'as pas été réécrit
print("==> Vérification nombre: ", cpt == cpt_verif)


#Générer csv
chemin = "csv/sources.csv"
ecrire_fichier_csv_liste_dict(chemin, L)