import re
import csv
import os
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
    """
    Fonction de traitement de la chaine de character donnée en paramètre provenant des données Ciqual de quantité de nutriment.
    :param teneur_brute: Le champ str de teneur qui correspond à un aliment — constituant
    :return: Le couple de valeur suite au traitement
    """
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


def ecrire_fichier_csv_liste_dict(nom_fichier, donnees):
    """
    Crée et remplie le fichier csv à l'emplacement donné avec les informations fournies.
    :param nom_fichier: L'emplacement du fichier cvs à remplir avec les données
    :param donnees: Une liste de dictionnaire tq clef = entête, valeur = donnée pour cet attribut
    :return: None
    """
    if nom_fichier is None or donnees is None:
        return

    dossier = os.path.dirname(nom_fichier)
    if dossier and not os.path.exists(dossier):
        os.makedirs(dossier)

    with open(nom_fichier, mode='w', newline='', encoding='utf-8') as fichier:
        stylo = csv.DictWriter(fichier, fieldnames=donnees[0].keys())
        stylo.writeheader()
        stylo.writerows(donnees)
    return