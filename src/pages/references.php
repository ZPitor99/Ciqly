<?php

require_once join(DIRECTORY_SEPARATOR,array(__DIR__,'..','php','class','php_vite','Manifest.php'));
require_once join(DIRECTORY_SEPARATOR,array(__DIR__,'..','php','utilitaire','reportage.php'));
$journaliste->logJournalRessource(22, null, null, null, null, null);

session_start();

$vite = new Manifest(
        dev: false,
        manifest_path: __DIR__.'/../../public/dist/.vite/manifest.json',
        base_path: '/dist/'
);

$tags = $vite->createTags("js/footer.js")

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="description" content="Synthèses des document de référent utilisé dans Ciqly">
    <title>Références | Ciqly</title>
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
    <section class="search-section bg-gradient">
        <div class="container">
            <h1>Sources et References des données utilisées</h1>
        </div>
    </section>
    <section class="search-section bg-white">
        <div class="container">
            <h2>Table Ciqual et aliments moyens</h2>

            <div>
                <p>
                    La documentation de la table ciqual et aliments moyens explicite les méthodes d'obtention des données, le calcul des données et l'interprétation des valeurs obtenues.
                    Cette dernière donne aussi des informations complémentaires sur les nutriments et présente les fichiers de données de la table Ciqual.
                </p>
                <a href="/static/documentation_table_ciqual.pdf" target="_blank" class="section-link" aria-label="Documentation pdf Ciqual de l'ANSES" title="Documentation pdf Ciqual de l'ANSES" download>Télécharger la documentation pdf</a>
            </div>

            <div>
                <h3>Version utilisée</h3>
                <h4>Table de composition nutritionnelle des aliments Ciqual 2025</h4>
                <div>
                    <p><strong>Titre :</strong> Table des aliments moyens Ciqual 2025</p>
                    <p><strong>Auteurs :</strong> Du Chaffaut Laure, Oseredczuk Marine, Gauvreau-Béziat Julie</p>
                    <p><strong>Organisation :</strong> Agence nationale de sécurité sanitaire de l’alimentation, de l’environnement et du travail</p>
                    <p><strong>Année :</strong> 2025</p>
                    <p><strong>Édition :</strong> V1</p>
                    <p><strong>Éditeur :</strong> Recherche Data Gouv</p>
                    <p><strong>DOI :</strong> https://doi.org/10.57745/XOJCLN</p>
                </div>
                <a href="https://entrepot.recherche.data.gouv.fr/dataset.xhtml?persistentId=doi:10.57745/RDMHWY" title="Lien vers recherche.data.gouv - Ciqual 2025" class="section-link" target="_blank" hreflang="fr">Ciqual 2025</a>
                <hr>
                <h4>Table des aliments moyens Ciqual 2025</h4>
                <div>
                    <p><strong>Titre :</strong> Table des aliments moyens Ciqual 2025</p>
                    <p><strong>Auteurs :</strong> Du Chaffaut Laure, Oseredczuk Marine, Gauvreau-Béziat Julie</p>
                    <p><strong>Organisation :</strong> Agence nationale de sécurité sanitaire de l’alimentation, de l’environnement et du travail</p>
                    <p><strong>Année :</strong> 2025</p>
                    <p><strong>Édition :</strong> V1</p>
                    <p><strong>Éditeur :</strong> Recherche Data Gouv</p>
                    <p><strong>DOI :</strong> https://doi.org/10.57745/XOJCLN</p>
                </div>
                <a href="https://entrepot.recherche.data.gouv.fr/dataset.xhtml?persistentId=doi:10.57745/XOJCLN" title="Lien vers recherche.data.gouv - Aliments moyens 2025" class="section-link" target="_blank" hreflang="fr">Aliments moyens 2025</a>
            </div>

            <div>
                <h3>Version précédente de la table Ciqual</h3>
                <div data-udata-dataset="5369a15fa3a729239d2065b7"></div>
                <script data-udata="https://www.data.gouv.fr/" src="https://www.data.gouv.fr/oembed.js" async defer></script>
            </div>
        </div>
    </section>
    <section class="search-section bg-sand">
        <div class="container">
            <h2 id="recommandation">À propos des nutriments et informations associées</h2>

            <div>
                <h3>Informations et valeurs recommandées</h3>
                <p>
                    Le rapport émis par l'ANSES sur les recommandations suites à étude menée à propos des vitamines et minéraux.
                    Des extraits des tableaux résultant de ce rapport ont été repris dans la section Nutriment du site web ou dans les valeurs de références dans l'Assemblage d'aliments.
                </p>
                <a href="/static/references_nutritionnelles_en_vitamines_mineraux.pdf" target="_blank" title="Rapport complet Vitamines et Minéraux - pdf" class="section-link" download>Actualisation des références nutritionnelles françaises en vitamines et minéraux - Mars 2021</a>
                <p>
                    Concernant les macros nutriments, les données à caractère informationnel sur les nutriments sont tirés des sites ci-dessous.
                </p>
                <ul>
                    <li>
                        <span> <a href="https://www.anses.fr/fr" target="_blank" hreflang="fr" class="section-link">Site web - ANSES</a> - Daté du 03/2026 </span>
                    </li>
                    <li>
                        <span> <a href="https://www.nutripro.nestle.fr/" target="_blank" hreflang="fr" class="section-link">Site web - Nutripro Nestle</a> - Daté du 03/2026 </span>
                    </li>
                    <li>
                        <span> <a href="https://wikiland.org/fr/Metabolizable_energy" target="_blank" hreflang="fr" class="section-link">Site web - Le système d'Atwater</a> - Daté du 03/2026 </span>
                    </li>
                    <li>
                        <span> <a href="https://www.larousse.fr/" target="_blank" hreflang="fr" class="section-link">Dictionnaire en ligne - Larousse</a> - Daté du 08/2026 </span>
                    </li>
                    <li>
                        <span> <a href="https://dictionnaire.lerobert.com/" target="_blank" hreflang="fr" class="section-link">Dictionnaire en ligne - Le Robert</a> - Daté du 08/2026 </span>
                    </li>
                </ul>
            </div>
            <hr>
            <div>
                <h3>Code Infoods</h3>
                <p>Les documents traitant de la classification INFOODS sont rassemblé ici. À la lumière de ces documents, la partie INFOODS de la section Nutriment du site web a été établie.</p>
                <ul>
                    <li>
                        <a href="/static/review_of_international_food_classification.pdf" target="_blank" title="Classification aliments - pdf" hreflang="en" class="section-link" download><span lang="en">Report on the Technical meeting on attributing AOAC methods to INFOODS tagnames</span></a>
                    </li>
                    <li>
                        <a href="/static/classification_infoods.pdf" target="_blank" title="Classification INFOODS - pdf" hreflang="en" class="section-link" download><span lang="en">Review of International Food Classification and Description</span></a>
                    </li>
                </ul>
            </div>
            <hr>
            <h2>A propos des documents utilisés</h2>
            <div>
                <ul>
                    <li>
                        <p>Georges Gardarin &mdash; Bases de données - Eyrolles (2003)</p>
                    </li>
                    <li>
                        <p>Djamal Belkasmi, Allel Hadjali, Hamid Azzoune &mdash; Relaxation des Requêtes Skyline : Une Approche Centrée Utilisateur - Communication dans un congrès (EGC 2016)</p>
                    </li>
                </ul>
            </div>
        </div>
    </section>
    <section class="search-section bg-white">
        <div class="container">
            <h2>Autres informations misent en avant sur le site</h2>
            <div>
                <a href="https://www.circana.com/fr-fr" hreflang="fr">
                    <img src="/static/images/circana-fr.png" alt="Logo de Circana LLC">
                </a>
                <blockquote lang="en" cite="https://www.circana.com/fr-fr">
                    "Consumers cite food & beverage and exercise as the top contributors to well-being, increasing in importance."
                </blockquote>
                <p>Source: <cite>Circana, NET® HABTS, YE March 2024</cite></p>
                <a href="/static/circana_global_health_and_wellness_market_extract.pdf" target="_blank" title="The Global Health and Wellness Market - pdf" hreflang="en" class="section-link" download><span lang="en">The Global Health and Wellness Market - A Pulse on Consumer Well-Being</span></a>
            </div>
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