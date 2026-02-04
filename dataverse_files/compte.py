import xml.etree.ElementTree as ET

def analyser_longueurs_xml(fichier_xml):
    """
    Parcourt tous les éléments COMPO et enregistre la longueur max de chaque champ
    """
    # Parser le fichier XML
    tree = ET.parse(fichier_xml)
    root = tree.getroot()

    # Dictionnaire pour stocker les longueurs maximales
    longueurs_max = {}
    unique = {"T"}

    # Compteur de COMPO traités
    nb_compo = 0

    # Parcourir tous les éléments COMPO
    for compo in root.findall('COMPO'):
        nb_compo += 1

        # Parcourir tous les enfants de COMPO
        for enfant in compo:
            nom_champ = enfant.tag

            # Récupérer le texte (contenu) de l'élément
            texte = enfant.text if enfant.text else ""
            # Nettoyer les espaces en début et fin
            texte = texte.strip()

            # Calculer la longueur
            longueur = len(texte)
            
            if nom_champ == "teneur":
                unique.add(texte)

            # Mettre à jour la longueur maximale
            if nom_champ not in longueurs_max:
                longueurs_max[nom_champ] = longueur
            else:
                longueurs_max[nom_champ] = max(longueurs_max[nom_champ], longueur)

    # Afficher les résultats
    print(f"Nombre de COMPO analysés : {nb_compo}")
    print("\nLongueurs maximales par champ :")
    print("-" * 40)

    for champ, longueur in sorted(longueurs_max.items()):
        print(f"{champ:20s} : {longueur:4d} caractères")
        
    tri = sorted(unique)
    
    for elem in tri:
        print(elem)
        

    return longueurs_max

# Utilisation
if __name__ == "__main__":
    fichier = "compo_2025_11_03.xml"  # Remplacer par le nom de votre fichier

    try:
        longueurs = analyser_longueurs_xml(fichier)
        a = input("coucou")
    except FileNotFoundError:
        print(f"Erreur : Le fichier '{fichier}' n'a pas été trouvé.")
    except ET.ParseError as e:
        print(f"Erreur lors du parsing du XML : {e}")
