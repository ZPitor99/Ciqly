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
            <p>
                En utilisant ce site, vous reconnaissez avoir pris connaissance de cet avertissement et acceptez les limites inhérentes aux données et aux calculs proposés.
            </p>
        </div>
    </section>

    <section>
        <div class="container">

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

