import re
#Fonction de traitement des champs des fichiers XML

def get_text(elem_xml, attr_releve):
    """
    Fonction de traitement des champs des fichiers XML
    :param elem_xml: L'élément XML récupéré avec lxml.
    :param attr_releve: Le nom de l'attribut XML duquel il faut extraire le champ contenu.
    :return: Le champ de l'attribut XML nettoyé (strip), None s'il est null.
    """
    el = elem_xml.find(attr_releve)
    if el is not None and el.text:
        rt = el.text.strip()
        return rt if rt != "-" else None
    return None

def normalise_teneur(teneur_brute):
    if teneur_brute is None:
        return None, None

    reg_exp = r"^\d+\.?\d*$"

    teneur_brute = teneur_brute.lower().strip()
    if "trace" in teneur_brute:
        return "TRACE", 0.0

    elif "<" in teneur_brute:
        return "INFÉRIEURE", float(teneur_brute.replace("<", "").replace(",", ".").strip())
    elif re.match(reg_exp,teneur_brute.replace(",", ".").strip()):
        return "EXACTE", float(teneur_brute.replace(",", ".").strip())
    else:
        return "ATT", None
