from lxml import etree
from tools_script_insert import get_text

xml = "../../dataverse_files/sources_2025_11_03.xml"


# Charger le fichier XML
tree = etree.parse(xml)
root = tree.getroot()

D_src = {}
cpt = 0
cpt_verif = 0
for compo in root.findall("SOURCES"):

    source_code = get_text(compo, "source_code")
    ref_citation = get_text(compo, "ref_citation")

    source_code = int(source_code)

    D_src[source_code] = ref_citation
    cpt += 1


for elem in D_src.items():
    print(elem)
    cpt_verif = cpt_verif+1

# cpt et cpt_verif afin de contrôler si un code du dictionnaire n'as pas été réécrit
print("==> Vérification nombre: ", cpt == cpt_verif)

