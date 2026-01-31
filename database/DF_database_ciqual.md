# Conception de la base de données

## Dépendances fonctionnelles

On note respectivement $U$ et $V$ les relation comprenant l'ensemble des attributs nécessaires à garantir les informations fournies par les deux fichiers de données de ANSEES de Ciqual et des aliments moyens.

### Dépendances fonctionnelles $U$

A partir de la documentation fournie et des fichiers XML, on déduit les dépendances fonctionnelles afin de constitue un schéma.

#### Aliments groupes

$alim\_grp\_code \rightarrow alim\_grp\_nom\_fr, alim\_grp\_nom\_eng$

$alim\_ssgrp\_code \rightarrow alim\_ssgrp\_nom\_fr, alim\_ssgrp\_nom\_eng$

$alim\_ssssgrp\_code \rightarrow alim\_ssssgrp\_nom\_fr, alim\_ssssgrp\_nom\_eng$

#### Aliments

$alim\_code \rightarrow alim\_nom\_fr, alim\_nom\_eng, alim\_nom\_sci, facteur\_jones$

$alim\_code \rightarrow alim\_grp\_code, alim\_ssgrp\_code, alim\_ssssgrp\_code$

#### Constituant

$const\_code \rightarrow const\_nom\_fr, const\_nom\_eng, code\_infoods$

#### Composition

$(alim\_code, const\_code) \rightarrow teneur, min, max, code\_confiance, source\_code$

#### Sources

$source\_code \rightarrow ref\_citation$

### Dépendance Fonctionnelles $V$

A partir de la documentation fournie et du fichier Excel, on déduit les informations et dépendances fonctionnelles afin de constitue un schéma.

Sachant que :

- $(alim\_moy\_code \cup alim\_contrib\_code) \subset alim\_code$

L'utilisation du symbole $\subseteq$ est impossible du faite des données actuelles

- $alim\_contrib\_code \cap alim\_moy\_code = \empty$

- $(alim\_moy\_code \cup alim\_contrib\_code) \cap alim\_code \neq \empty$

#### Aliments moyens

$alim\_moy\_code \rightarrow alim\_moy\_nom$

$alim\_contrib\_code \rightarrow alim\_contrib\_nom$

$(alim\_moy\_code, alim\_contrib\_code) \rightarrow pourcentage$

### Graphe des dépendances fonctionnelles natives

![Schema DF excalidraw](C:\Users\gabri\Documents\production_data\prod_ciqual\2025\Schema_DF_DI_Ciqual_Aliments_moyens.png "Tux")

### Remarques

#### Première remarque

Or on constate qu'un équivalent au DF des aliments moyen existe.

En effet, très justement, on remarque que :

- $alim\_moy\_nom$ et $alim\_contrib\_nom$ $\Leftrightarrow$ $alim\_nom\_fr$ et que les DF 
  
  - $alim\_moy\_code \rightarrow alim\_moy\_nom$
  
  - $alim\_contrib\_code \rightarrow alim\_contrib\_nom$ 
  
  sont équivalentes à $alim\_code \rightarrow alim\_nom\_fr$, elles produisent même une redondance. Elles ont été inscrites précédemment pour respecter les fichiers originaux de données.

#### Deuxième remarque

De plus, après observation des données en profondeur, on relève que :

- $alim\_ssssgrp\_code \rightarrow alim\_ssgrp\_code$

- $alim\_ssgrp\_code \rightarrow alim\_grp\_code$

a condition de traiter tout type de groupe (group, sous groupe et sous sous groupe ) d'aliment comme `null` et non comme ayant le `000000` avec des nom `null`.

De plus, en conceptions de base de données, les code sous-groupe et sous-sous-groupe ne doivent pas être constitués par agrégation (fusion) des groupes parents:

![](C:\Users\gabri\Documents\production_data\prod_ciqual\2025\pb_groupes.png)

On reconsidère le schéma :

![Schema DF excalidraw](C:\Users\gabri\Documents\production_data\prod_ciqual\2025\Schema_DF_DI_Ciqual_Aliments_moyens_bis.png "Tux")

## Clef de $U$

D'après le graphe ci-dessus, on remarque que la clef ($alim\_code,const\_code$) est minimal et détermine tout les attributs. 

## Clef de $V$

De même, on déduit que la clef ($alim\_moy\_code,alim\_contrib\_code$) n'étant pas moi d'un couple ainsi définie ($alim\_code,alim\_code$) est minimal et  détermine tout les attributs.

## Unifier $U$ et $V$

Pour définir une clef commune à $U$ et $V$, il faut satisfaire la contrainte : 
$(alim\_moy\_code \cup alim\_contrib\_code) = alim\_code$
Alors, il faudra créer les enregistrement pour satisfaire la DF 
$(alim\_moy\_code, alim\_contrib\_code) \rightarrow pourcentage$
pour toute codification d'aliment; c'est à dire tel que les 
$alim\_code \not\subset (alim\_moy\_code \cup alim\_contrib\_code)$
sont de la forme : 

- $alim\_moy\_code$ est null
- $alim\_contrib\_code$ est les $alim\_code$ non présent
- $pourcentage$ est null

Alors $alim\_moy\_code$ comprend l'ensemble des aliments génériques et $alim\_contrib\_code$ sont des aliments pouvant, ou pas, être associé à un aliments génériques.
$alim\_contrib\_code \cap alim\_moy\_code = \empty$ est toujours satisfait

## Algorithme de Bernstein

### Couverture minimal

#### Réduction à droite

$alim\_grp\_code \rightarrow alim\_grp\_nom\_fr$
$alim\_grp\_code \rightarrow alim\_grp\_nom\_eng$

$alim\_ssgrp\_code \rightarrow alim\_ssgrp\_nom\_fr$
$alim\_ssgrp\_code \rightarrow alim\_ssgrp\_nom\_eng$

$alim\_ssssgrp\_code \rightarrow alim\_ssssgrp\_nom\_fr$
$alim\_ssssgrp\_code \rightarrow alim\_ssssgrp\_nom\_eng$

$alim\_ssgrp\_code \rightarrow alim\_grp\_code$
$alim\_ssssgrp\_code \rightarrow alim\_ssgrp\_code$

$alim\_code \rightarrow alim\_nom\_fr$
$alim\_code \rightarrow alim\_nom\_eng$
$alim\_code \rightarrow alim\_nom\_sci$
$alim\_code \rightarrow facteur\_jones$
$alim\_code \rightarrow alim\_grp\_code$
$alim\_code \rightarrow alim\_ssgrp\_code$
$alim\_code \rightarrow alim\_ssssgrp\_code$

$const\_code \rightarrow const\_nom\_fr$
$const\_code \rightarrow const\_nom\_eng$
$const\_code \rightarrow code\_infoods$ 

$(alim\_code, const\_code) \rightarrow teneur$
$(alim\_code, const\_code) \rightarrow min$
$(alim\_code, const\_code) \rightarrow max$
$(alim\_code, const\_code) \rightarrow code\_confiance$
$(alim\_code, const\_code) \rightarrow source\_code$

$source\_code \rightarrow ref\_citation$

$alim\_moy\_code \rightarrow alim\_moy\_nom$

$alim\_contrib\_code \rightarrow alim\_contrib\_nom$

$(alim\_moy\_code, alim\_contrib\_code) \rightarrow pourcentage$

#### Réduction à gauche

#### Suppression des redondances
