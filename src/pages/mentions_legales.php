<?php

require_once join(DIRECTORY_SEPARATOR,array(__DIR__,'..','php','class','php_vite','Manifest.php'));

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
    <title>Mentions Legales | Ciqly</title>
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
        <div class="section container" >
            <h1 class="page-title">
                Mentions Legales
            </h1>
        </div>
    </section>
    <section id="av-calcul-val-nutrition" class="section">
        <div class="container">
            <h2>À propos des valeurs nutritionnelles affichées</h2>
            <p>
                Les résultats affichés par le calculateur (assemblage d'aliment via le panier) sont des estimations obtenues à partir des données de la <em>table CIQUAL de l'ANSES</em>, une base de référence sur la composition nutritionnelle des aliments en France.
                Les valeurs calculées ont pour objectif de vous donner un ordre de grandeur de l'apport nutritionnel d'un assemblage d'aliments. Elles ne constituent pas une analyse de laboratoire.
            </p>
            <h3>Les résultats peuvent différer de la réalité</h3>
            <p>
                La composition d'un aliment peut varier selon de nombreux facteurs :
            </p>
            <ul>
                <li>&bull; La variété ou l'origine des ingrédients ;</li>
                <li>&bull; La saison et les conditions de production ;</li>
                <li>&bull; La cuisson, la préparation et le mode de conservation ;</li>
                <li>&bull; Les différences entre fabricants ou entre lots de fabrication.</li>
            </ul>
            <p>
                Par ailleurs, certaines données de la base CIQUAL correspondent à des valeurs maximales, des estimations ou des moyennes. Lorsqu'elles sont utilisées dans un calcul, le résultat obtenu peut donc être légèrement supérieur ou inférieur à la composition réelle de votre préparation.
            </p>
            <hr>
            <h3>Utilisation des résultats</h3>
            <p>
                Les informations fournies sur ce site sont destinées à un usage informatif et pédagogique. Elles ne doivent pas être utilisées comme origine unique pour :
            </p>
            <ul>
                <li>&bull; Etablir un régime alimentaire ou un programme nutritionnel personnalisé ;</li>
                <li>&bull; Prendre une décision médicale ;</li>
                <li>&bull; Remplacer l'avis d'un professionnel de santé ou d'un diététicien ;</li>
                <li>&bull; Réaliser un étiquetage nutritionnel ou toute démarche réglementaire.</li>
            </ul>
            <hr>
            <h3>Responsabilité</h3>
            <p>
                Malgré le soin apporté au développement de ce calculateur et à l'utilisation des données de la table CIQUAL de l'ANSES, aucune garantie ne peut être donnée quant à l'exactitude parfaite des résultats obtenus.
            <br>
                L'utilisation des informations affichées se fait sous la seule responsabilité de l'utilisateur. L'éditeur du site ne pourra être tenu responsable des conséquences liées à leur interprétation ou à leur utilisation.
            </p>
            <br>
        </div>
    </section>

    <section>
        <div class="container">
            <h2>À propos des quantités de référence recommandées</h2>
            <p>
                Les quantités de référence affichées sur ce site sont fournies à titre indicatif afin de permettre une mise en perspective des apports nutritionnels calculés.
                Ces valeurs sont établies à partir des références nutritionnelles publiées par l'ANSES, notamment dans l'avis du 2 mars 2021 relatif à l'actualisation des références nutritionnelles françaises en vitamines et minéraux <a href="/references#recommandation" target="_self" hreflang="fr" class="section-link">Voir les références</a>. Selon les nutriments, les valeurs retenues correspondent aux références les plus pertinentes (par exemple : <abbr title="Besoin nutritionnel moyen">BNM</abbr> ou <abbr title="Apport satisfaisant">AS</abbr> ou autre valeur de référence définie par l'ANSES).
            </p>
            <hr>
            <h3>Porté des valeurs de références</h3>
            <p>
                Lorsque les recommandations diffèrent selon le sexe, une valeur représentative de la population adulte a été retenue, calculée à partir des recommandations applicables aux femmes et aux hommes adultes. Cette valeur ne correspond donc pas à une recommandation officielle pour une catégorie particulière de population, mais à un indicateur destiné à faciliter la comparaison des apports.
                <br>
                Ces références concernent exclusivement les adultes en bonne santé. Elles ne sont pas adaptées aux besoins spécifiques de certaines populations, notamment les enfants, les adolescents, les femmes enceintes ou allaitantes, les personnes âgées, les sportifs ou les personnes présentant une pathologie ou une situation physiologique particulière.
            </p>
            <hr>
            <h3>Objectif et appréciation</h3>
            <p>
                Les pourcentages affichés par rapport à ces valeurs ont uniquement une vocation informative. Ils permettent d'apprécier l'ordre de grandeur d'un apport nutritionnel au regard de références générales et ne constituent ni une évaluation personnalisée des besoins, ni un avis médical ou diététique.
                Les références nutritionnelles utilisées peuvent être mises à jour en fonction de l'évolution des connaissances scientifiques ou de la publication de nouvelles recommandations officielles.
            </p>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div>
                <p>
                    <b>En utilisant ce site, vous reconnaissez avoir pris connaissance de cet avertissement et acceptez les limites inhérentes aux données, calculs et recommandations proposés.</b>
                </p>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <h2>À propos des Cookies et données de navigation</h2>

            <h3>Cookies utilisés</h3>
            <p>Le site utilise uniquement des cookies techniques (sessions). Ces cookies sont strictement nécessaires au fonctionnement du site et sont automatiquement supprimés à la fermeture du navigateur. Aucun cookie de suivi publicitaire ou de traçage à long terme n'est déposé.</p>
            <hr>

            <h3>Journaux de connexion</h3>
            <p>À des fins statistiques, permettant d'analyser la fréquentation du site et de l'améliorer (évolution des fonctionnalités, mise en avant des contenus populaires, amélioration de l'ergonomie), les informations suivantes sont enregistrées dans nos journaux techniques :</p>
            <ul>
                <li>- Les pages consultées, horodatées ;</li>
                <li>- Les aliments consultés, horodatés, ainsi que l'ensemble des interactions effectuées avec ces aliments</li>
            </ul>
            <br>
            <p>Ces informations sont corrélées à l'identifiant de session (session ID) généré par le cookie de session. Cet identifiant étant réinitialisé à chaque fermeture du navigateur, deux visites distinctes d'une même personne sont traitées comme provenant de deux utilisateurs différents. Ces données de navigation sont donc totalement anonymes : elles ne permettent à aucun moment d'identifier ou de suivre une personne physique dans la durée. D'autre part, le cookie est régénéré au bout de 24h d'existence, ce qui empêche identification de manière prolongée.</p>
            <hr>

            <h3>Durée de conservation</h3>
            <p>Les données détaillées par session sont conservées pendant une durée maximale de 1 mois. Passé ce délai, elles ne sont conservées que sous forme agrégée (statistiques globales de fréquentation), ne comportant plus aucune donnée individuelle liée à une session ou à un identifiant particulier.</p>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <h2>À propos de l'hébergement et contact</h2>
            <address>
                Redirection (via tunnel/proxy) :<br>
                Cloudflare, Inc.<br>
                101 Townsend Street, San Francisco, CA 94107, États-Unis.<br>
                <br>
                Nom de domaine enregistré auprès de :<br>
                OVH SAS<br>
                2 rue Kellermann, 59100 Roubaix, France.<br>
                (OVH n'héberge aucun contenu du site)<br>
                <br>
                Éditeur :<br>
                ZPitor99 - Contact direct : <a href="mailto:contact@ciqly.fr">contact@ciqly.fr</a><br>
                Réquisition auprès d'OVH SAS.<br>
            </address>
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

