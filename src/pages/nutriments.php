<?php

require_once join(DIRECTORY_SEPARATOR,array(__DIR__,'..','php','class','php_vite','Manifest.php'));

session_start();

$vite = new Manifest(
        dev: false,
        manifest_path: __DIR__.'/../../public/dist/.vite/manifest.json',
        base_path: '/dist/'
);

$tags = $vite->createTags("js/nutriments.js")

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="description"
          content="Nutriments - CIQLY — Informations relatives aux nutriments utilisés dans le Ciqual."/>
    <title>Nutriments - Ciqly</title>
    <link rel="icon" type="image/x-icon" href="/static/images/icone_ciqly.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="/static/images/icone_ciqly-32.png">
    <link rel="icon" type="image/png" sizes="180x180" href="/static/images/icone_ciqly-180.png">
    <link rel="icon" type="image/svg+xml" href="/static/images/icone_ciqly.svg">
    <?= $tags->css ?>

</head>
<body>


<?php
include(join(DIRECTORY_SEPARATOR,array(__DIR__,'..','fragments','header.html')));
?>

<!-- ── MAIN ─────────────────────────────────────────────── -->
<main id="main-content">

    <section>
        <div class="bg-gradient">
            <h1 class="section-header-center">Les Nutriments</h1>
        </div>
    </section>

    <section class="search-section bg-sand">

        <div class="container">
            <div class="section-header">
                <h2>Les nutriments principaux</h2>
            </div>
            <div>
<!-- ── LES NUTRIMENTS ─────────────────────────────────────────────── -->
                <div>
                    <h3>Informations sur les nutriments</h3>

                    <h4>Les macronutriments</h4>
                        <div>
                            <br>
                            <h5>Les lipides</h5>
                                <a href="https://www.anses.fr/fr/content/les-lipides"
                                   target="_blank" hreflang="fr" class="section-link">Anses - Lipides</a>
                                <p>
                                    Les lipides sont plus couramment appelé "graisses".
                                    L'ANSES recommande que les lipides représentent 35 à 40 % de la part de l'apport énergétique.
                                    Compte tenu des familles d'aliments et la nature des lipides contenus, les acides gras représentent 56% à 95% des lipides totaux.
                                </p>
                            <br>
                            <h5>Les glucides</h5>
                                <a href="https://www.anses.fr/fr/content/sucres-dans-lalimentation"
                                   target="_blank" hreflang="fr" class="section-link">Anses - Glucides</a>
                                <p>
                                    Parmi les glucides, on distingue les glucides simples (sucres) et les glucides complexes (amidons).
                                    La part énergétique quotidienne apportée par les glucides recommandée est de 50 à 55 %
                                    D'autre part, il est recommandé de ne pas consommer plus de 100 g de sucres totaux par jour (hors lactose et galactose).
                                </p>

                            <br>
                            <h5>Les protéines</h5>
                                <a href="https://www.anses.fr/fr/content/proteines-role-sources-et-apports-recommandes"
                                   target="_blank" hreflang="fr" class="section-link">Anses - Protéines</a>
                                <p>
                                    Les protéines sont constituées d’un enchaînement d’acides aminés. On distingue les acides aminés non-indispensables,
                                    car elles peuvent être produites de manière endogène ; Et les acides aminés essentiels que l’on doit se procurer obligatoirement par l’alimentation.
                                    Il est recommandé que la ration des protéines dans l'apport énergétique soit compris entre 10 et 20%.
                                </p>
                        </div>
                    <hr>

                    <h4>Les minéraux</h4>
                        <div>
                            <a href="https://www.anses.fr/fr/content/les-mineraux"
                               target="_blank" hreflang="fr" class="section-link">Anses - Les Minéraux</a>
                            <p>
                                Les éléments minéraux représentent environ 4% du poids corporel.
                            </p>
                            <p>
                                Le <abbr title="Besoin nutritionnel moyen">BNM</abbr> est le besoin moyen au sein de la population et l'<abbr title="Apport satisfaisant">AS</abbr>,
                                l'apport satisfaisant, c'est-à-dire le statut nutritionnel jugé satisfaisant.
                                L'<abbr title="Apport satisfaisant">AS</abbr> est utilisé quand le <abbr title="Besoin nutritionnel moyen">BNM</abbr> ne peut pas être estimé, faute de données suffisantes.<br>
                                D'autre part, La <abbr title="Limite supérieure de sécurité">LSS</abbr> est définie comme l'apport journalier maximal considéré comme peu susceptible de présenter un risque d'effets indésirables sur la santé.<br>
                                Ci-joint les recommandations d'apport mineral quotidien : <a href="/static/extrait_apport_mensuel_mineraux_anses.pdf" class="section-link" aria-label="Extrait du rapport pdf de l'ANSES" title="Extrait du rapport pdf de l'ANSES" download>Télécharger les tableaux pdf</a><br>
                                C.f Ressources puis Références en <a href="#footer"><strong>bas de page</strong></a> pour accéder au document complet ou directement sur le site de l'ANSES.
                            </p>
                        </div>

                    <hr>

                    <h4>Les vitamines</h4>
                        <div>
                            <a href="https://www.anses.fr/fr/content/dossier/tout-savoir-sur-les-vitamines-roles-bienfaits-et-risques"
                               target="_blank" hreflang="fr" class="section-link">Anses - Les vitamines</a>
                            <p>
                                On distingue deux types de vitamines : les liposolubles et les hydrosolubles.
                                Leur nom se réfère à leur milieu de dissolution, les premières dans la graisse et les secondes dans l'eau.
                                Les vitamines A, D, E, K sont de type liposolubles et les hydrosolubles sont les vitamines B et C.
                            </p>
                            <p>
                                Le <abbr title="Besoin nutritionnel moyen">BNM</abbr> est le besoin moyen au sein de la population et l'<abbr title="Apport satisfaisant">AS</abbr>,
                                l'apport satisfaisant, c'est-à-dire le statut nutritionnel jugé satisfaisant.
                                L'<abbr title="Apport satisfaisant">AS</abbr> est utilisé quand le <abbr title="Besoin nutritionnel moyen">BNM</abbr> ne peut pas être estimé, faute de données suffisantes.<br>
                                D'autre part, La <abbr title="Limite supérieure de sécurité">LSS</abbr> est définie comme l'apport journalier maximal considéré comme peu susceptible de présenter un risque d'effets indésirables sur la santé.<br>
                                Ci-joint les recommandations d'apport vitamin quotidien : <a href="/static/extrait_apport_mensuel_vitamines_anses.pdf" class="section-link" aria-label="Extrait du rapport pdf de l'ANSES" title="Extrait du rapport pdf de l'ANSES" download>Télécharger les tableaux pdf</a><br>
                                C.f Ressources puis Références en <a href="#footer"><strong>bas de page</strong></a> pour accéder au document complet ou directement sur le site de l'ANSES.
                            </p>
                        </div>

                </div>
                <hr>
 <!-- ── LES VALEURS ENERGETIQUES ─────────────────────────────────────────────── -->
                <div>
                    <h3>Valeurs énergétiques sur les nutriments</h3>

                    <h4>Les Facteurs d'Atwater</h4>
                        <p>
                            Dans les années 1880-1890, Wilbur Olin Atwater, chimiste américain,
                            définie dans ses travaux sur la nutrition l'énergie brute d'un aliment.<br>
                            L'énergie brute (GE) d'un aliment représente la quantité totale d'énergie libérée
                            lors de sa combustion complète, mesurée par calorimétrie de bombe. Elle est égale
                            à la somme des chaleurs de combustion de ses trois macronutriments : les protéines
                            (GE<sub>p</sub>), les lipides (GE<sub>f</sub>) et les glucides calculés par différence
                            (GE<sub>cho</sub>), selon le système des analyses proximales.<br>
                            Cette formule — <strong>GE = GE<sub>p</sub> + GE<sub>f</sub> + GE<sub>cho</sub></strong> —
                            constitue le point de départ de la chaîne d'évaluation de la valeur énergétique des aliments,
                            bien que l'énergie effectivement disponible pour l'organisme soit inférieure en raison des
                            pertes digestives et métaboliques.
                        </p>

                    <hr>

                    <h4>Complément sur les valeurs énergétiques de la table Ciqual</h4>
                        <p>
                            Au-delà des facteurs d'Atwater, la valeur énergétiques des aliments de la table Ciqual
                            a été calculée en utilisant les coefficients suivants :
                        </p>
                        <br>
                        <ul>
                            <li>- pour les lipides : 37 kJ/g (9 kcal/g) ;</li>
                            <li>- pour les protéines : 17 kJ/g (4 kcal/g) ;</li>
                            <li>- pour les glucides (à l'exception des polyols) : 17 kJ/g (4 kcal/g) ;</li>
                            <li>- pour l'alcool (éthanol) : 29 kJ/g (7 kcal/g) ;</li>
                            <li>- pour les acides organiques : 13 kJ/g (3 kcal/g) ;</li>
                            <li>- pour les polyols : 10 kJ/g (2,4 kcal/g) ;</li>
                            <li>- pour les fibres alimentaires : 8 kJ/g (2 kcal/g) ;</li>
                        </ul>
                    <br>
                    <p>
                        C.f Ressources puis Références en <a href="#footer"><strong>bas de page</strong></a> pour accéder à la documentation complète Ciqual ou directement sur le site de l'ANSES.
                    </p>
                </div>
            </div>
        </div>
    </section>


    <section class="search-section bg-white">
        <div class="container">
            <div class="section-header">
                <h2>Tous les nutriments</h2>
                <a href="https://www.fao.org/infoods/infoods/standards-guidelines/food-component-identifiers-tagnames/en/"
                   target="_blank" hreflang="en" class="section-link">Site Infoods →</a>
            </div>

            <h3>Les nutriments renseignés dans l'étude Ciqual</h3>
            <p>
                Le code INFOODS a pour but d'identifier de manière claire et non ambiguë les composants alimentaires dans des bases de données de composition des aliments.
                Il utilise des codes ou des abréviations standardisés pour permettre de comparer et combiner correctement les valeurs nutritionnelles provenant de différentes sources.
                <br>
                <cite>
                    « Le système garantit une identification claire et indépendante de la langue des composants, permettant aux utilisateurs de distinguer les valeurs comparables et combinables de celles qui sont différentes »
                </cite>
                et
                <cite>
                    « Les tagnames INFOODS sont comme des codes ou des abréviations […] permettant de définir les composants de façon claire et sans ambiguïté avec seulement quelques caractères »
                </cite>
                .
            </p>
            <br>
            <div style="overflow-x:auto" x-data="infoods">
                <table class="data-table" aria-label="Tableau des nutriments de l'étude Ciqual">
                    <caption>Tableau des codes INFOODS de l'étude Ciqual triés par code</caption>
                    <thead>
                    <tr>
                        <th scope="col">Nutriment</th>
                        <th scope="col">Code INFOODS</th>
                    </tr>
                    </thead>

                    <tbody>
                        <template x-for="item in table_infoods" :key="item.nom">
                            <tr>
                                <td><span class="food-badge" x-text="item.nom"></span></td>
                                <td x-text="item.code"></td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

</main>

<!-- ── FOOTER ─────────────────────────────────────────────── -->
<?php
include(join(DIRECTORY_SEPARATOR,array(__DIR__,'..','fragments','footer.html')));
?>

</body>
<?= $tags->js ?>
</html>