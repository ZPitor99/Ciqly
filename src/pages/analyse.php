<?php

require_once join(DIRECTORY_SEPARATOR,array(__DIR__,'..','php','class','php_vite','Manifest.php'));

session_start();

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

    <section>
        <div>
            <h1 class="section-header-center">Analyse complexe</h1>
        </div>
    </section>


    <section class="bg-sand">
        <div class="container">
            <div class="section-header">
                <h2>Les plus populaires</h2>
            </div>

            <div>

            </div>

        </div>
    </section>

    <section class="bg-white">
        <div class="container">
            <div class="section-header">
                <h2><span lang="en">Skyline</span></h2>
            </div>

            <div>

                <div id="req1"></div>

            </div>

        <div>
    </section>

    <section class="bg-gradient">
        <div class="container">
            <div class="section-header">
                <h2>Analytique</h2>
            </div>

            <div>

            </div>

        <div>
    </section>

</main>

<!-- ── FOOTER ─────────────────────────────────────────────── -->
<?php
include(join(DIRECTORY_SEPARATOR,array(__DIR__,'..','fragments','footer.php')));
?>

</body>
<?= $tags->js ?>
</html>