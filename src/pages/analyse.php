<?php

require_once join(DIRECTORY_SEPARATOR,array(__DIR__,'..','php','class','php_vite','Manifest.php'));

require_once join(DIRECTORY_SEPARATOR,array(__DIR__,'..','php','utilitaire','reportage.php'));
$journaliste->logJournalRessource(5, null, null, null, null, null);

$vite = new Manifest(
    dev: false,
    manifest_path: __DIR__.'/../../public/dist/.vite/manifest.json',
    base_path: '/dist/'
);

$tags = $vite->createTags("js/analyse.js")

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <title>Analyse complexe | Ciqly</title>
    <link rel="icon" type="image/x-icon" href="/static/images/icone_ciqly.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="/static/images/icone_ciqly-32.png">
    <link rel="icon" type="image/png" sizes="180x180" href="/static/images/icone_ciqly-180.png">
    <link rel="icon" type="image/svg+xml" href="/static/images/icone_ciqly.svg">
    <?= $tags->css ?>
</head>
<body>

<?php
include(join(DIRECTORY_SEPARATOR,array(__DIR__,'..','fragments','header.php')));
?>

<!-- ── MAIN ─────────────────────────────────────────────── -->
<main id="main-content">

    <section class="bg-sand">
        <div>
            <h1 class="section-header-center">Analyse complexe</h1>
        </div>
    </section>


    <section class="section bg-sand">
        <div class="container">
            <p>
                Ce site s'appuie sur une base de données nutritionnelles construite à partir de CIQUAL, normalisée et nettoyée afin d'en permettre une exploitation approfondie. Au-delà de la simple consultation des valeurs nutritionnelles, cette page est consacrée à une analyse plus poussée de ces données, mobilisant différentes techniques.
                <br>
                Trois approches y sont présentées : <b>les requêtes Skyline</b>, basées sur le principe de Pareto, permettant d'identifier les aliments les plus pertinents selon plusieurs critères simultanés ; <b>les requêtes analytiques</b>, mobilisant des outils statistiques pour dégager des tendances au sein des données ; et enfin <b>une extraction des préférences utilisateurs</b>, fondée sur les aliments les plus consultés sur le site.
            </p>
            <br>
            <p>
                <em>
                    Cette page aborde des concepts techniques liés aux bases de données et à l'analyse statistique. Une certaine familiarité avec ces domaines facilitera la compréhension des méthodes présentées. Elle reste néanmoins accessible à toute personne curieuse souhaitant découvrir les coulisses de l'exploitation des données, même sans expertise technique préalable.
                </em>
            </p>
            <br>
            <p>
                Pour rappel, le schéma de la base de donnée utilisé par Ciqly (données CIQUAL) :
            </p>
            <img class="thumb" src="/static/images/schema_ciqly_data.png" alt="Schéma de la base de donnée Ciqly (partie data issue de CIQUAL)" loading="lazy">
        </div>
    </section>

    <div class="overlay" id="overlay">
        <span class="close-btn" id="closeBtn">&times;</span>
        <img src="" alt="Image agrandie" id="modalImg">
    </div>


    <section class="section bg-white">
        <div class="container" x-data="{ req_open: false}">
            <div class="section-header">
                <h2><span lang="en">Skyline</span></h2>
                <p>
                    <b>Définition :</b> Soit D un ensemble de points à d dimensions et u<sub>i</sub> et u<sub>j</sub> deux points de D.
                    On dit que u<sub>i</sub> domine (au sens de Pareto) u<sub>j</sub> (noté u<sub>i</sub> ≻ u<sub>j</sub>) si et seulement si u<sub>i</sub> est meilleur ou égal à u<sub>j</sub> sur toutes les dimensions et strictement meilleur que u<sub>j</sub> sur au moins une dimension.
                    <br>Ainsi :
                </p>
                <div> <span>u<sub>i</sub> ≻ u<sub>j</sub></span> <span>&hArr;</span> <span> ( &forall; k &isin; {1, ..., d}, u<sub>i</sub>[k] &ge; u<sub>j</sub>[k] ) </span> <span>&and;</span> <span> ( &exist; q &isin; {1, ..., d}, u<sub>i</sub>[q] &gt; u<sub>j</sub>[q] ) </span> </div>
                <p>Un tuple domine un autre s'il est aussi bon sur tous les critères, et strictement meilleur sur au moins un critère. Une requête skyline retourne alors uniquement les tuples qui ne sont dominés par aucun autre, c'est-à-dire les meilleurs compromis possibles entre les différents critères. En effet, l'opération de skyline répond à une optimisation multi-critères</p>
            </div>


            <div>
                <h3>Aliment ayant la plus haute teneur pour chaque nutriment et une confiance élevée</h3>
                <p>
                    La première requête proposée a pour but de trouver, pour chaque nutriment, l'aliment qui possède la plus haute teneur de ce nutriment, et de maximiser le code de confiance associé à cette valeur.
                    Cela permet de déterminer les aliments les plus riches pour chaque nutriment.
                </p>
                <button class="btn btn--outline mt-2" type="button" @click="req_open = !req_open">
                    Consulter la requête Skyline (SQL)
                </button>
                <div class="menu-dropdown_aff mt-2" x-show="req_open" x-cloak x-transition:enter.duration.400ms x-transition:leave.duration.300ms>
                    <div id="req1"></div>
                </div>
                <div class="mt-4">
                    <p>
                        Le tableau suivant présente le résultat de la requête Skyline à propos des nutriments les plus pertinents pour le grand public. Les nutriments <em>Eau</em> et <em>Énergie</em> ont été écarté, car il retourne un trop grand nombre de tuples (± 25). En effet, pour l'Eau, tous les types d'eau minérale sont retournées. Concernant l'énergie, il s'agit du même phénomène avec les types d'huile (colza, tournesol, colza, etc).
                        <br>
                        Cette situation se produit quand les tuples sont identiques, par exemple pour l'eau, toutes les eaux minérales (quelle que soit la source) ont une Teneur en Eau de 100 et un Code de Confiance A.
                        <br>
                        Si un seul tuple est retourné pour un nutriment, cela indique que l'aliment possédant la plus haute teneur à aussi le code de confiance maximal (A).
                    </p>
                    <div class="data-table mt-4">
                        <?php
                        include(join(DIRECTORY_SEPARATOR,array(__DIR__,'..','fragments','skyline_req_tab.php')));
                        ?>
                    </div>
                </div>
                <p class="mt-4">
                    <b>Exemple :</b> Prenons le Zinc ci-dessus, la requête a retenu deux aliments : l'huître plate et les graines de tournesol grillées salées. L'huître plate crue domine concernant la teneur, 45 mg de zinc pour 100 g, mais la fiabilité de cette donnée est faible (confiance D). La graine de tournesol contient un peu moins de zinc (36 mg/100 g), en revanche cette valeur est très fiable (confiance A). Ce sont les meilleurs compromis entre les dimensions.
                </p>
            </div>

        <div>
    </section>

    <section class="section bg-gradient">
        <div class="container">
            <div class="section-header">
                <h2>Analytique</h2>
            </div>

            <div>

            </div>

        <div>
    </section>

    <section class="section bg-sand">
        <div class="container">
            <div class="section-header">
                <h2>Les plus populaires</h2>
            </div>

            <div>

            </div>

        </div>
    </section>

    <section>
        <div>
            <p>
                La conception d'une base de données constitue une étape déterminante dans la fiabilité et la cohérence des données qu'elle héberge. Elle vise notamment à éviter les redondances, les anomalies de mise à jour et les incohérences, en s'appuyant sur une modélisation rigoureuse des données et de leurs relations. Cette démarche repose en particulier sur la notion de dépendance fonctionnelle, qui permet d'identifier la manière dont les attributs d'une relation se déterminent mutuellement, et sur le respect des trois premières formes normales (1FN, 2FN, 3FN), garantissant une structuration des données exempte de redondances superflues. La conception présentée ici s'appuie sur les principes exposés par Georges Gardarin dans Bases de données (5e tirage, 2003, Eyrolles).
                <br>
                À partir des fichiers sources fournis par l'ANSES (données Ciqual au format XML et fichier des aliments moyens au format XLSX), une analyse a permis d'établir l'ensemble des dépendances fonctionnelles régissant les données. Ces dépendances ont ensuite été affinées à travers l'identification des clés minimales de chaque relation, avant l'application de l'algorithme de synthèse de Bernstein afin d'obtenir une décomposition en troisième forme normale. Cette démarche a notamment nécessité de traiter des cas particuliers, tels que la hiérarchie des groupes d'aliments ou l'unification des schémas issus des deux sources de données, pour aboutir à un schéma relationnel final, support de la création de la base de données.
            </p>
        </div>
    </section>

</main>

<!-- ── FOOTER ─────────────────────────────────────────────── -->
<?php
include(join(DIRECTORY_SEPARATOR,array(__DIR__,'..','fragments','footer.php')));
?>

</body>
<?= $tags->js ?>
</html>