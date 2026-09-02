<?php

require_once join(DIRECTORY_SEPARATOR,array(__DIR__,'..','php','class','php_vite','Manifest.php'));

require_once join(DIRECTORY_SEPARATOR,array(__DIR__,'..','php','utilitaire','reportage.php'));
$journaliste->logJournalRessource(33, null, null, null, null, null);

$vite = new Manifest(
    dev: false,
    manifest_path: __DIR__.'/../../public/dist/.vite/manifest.json',
    base_path: '/dist/'
);

$tags = $vite->createTags("js/contact.js")

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <title>Contact | Ciqly</title>
    <link rel="icon" type="image/x-icon" href="/static/images/icone_ciqly.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="/static/images/icone_ciqly-32.png">
    <link rel="icon" type="image/png" sizes="180x180" href="/static/images/icone_ciqly-180.png">
    <link rel="icon" type="image/svg+xml" href="/static/images/icone_ciqly.svg">
    <?= $tags->css ?>
</head>
<body style="display: flex; flex-direction: column; min-height: 100vh;">

<?php
include(join(DIRECTORY_SEPARATOR,array(__DIR__,'..','fragments','header.php')));
?>

<!-- ── MAIN ─────────────────────────────────────────────── -->
<main id="main-content" style="flex: 1;">

    <section class="section section--tight bg-sand">
        <div class="container container--narrow contact">

            <div>
                <span class="section-label">Contact</span>
                <h1>Une question, une remarque&nbsp;?</h1>
            </div>

            <div class="contact-mail-row">
                <span class="contact-mail-address">contact@ciqly.fr</span>
                <a href="mailto:contact@ciqly.fr" class="contact-mail" aria-label="Envoyer un email à contact@ciqly.fr">
                    <span>Envoyer un mail</span>
                </a>
            </div>

            <div class="contact-examples">
                <ul class="contact-example-list">

                    <li class="contact-example">
                        <div class="contact-example__content">
                            <h3>Demande d'informations</h3>
                            <p>Vous avez une question sur les données ou le fonctionnement du site.</p>
                        </div>
                    </li>

                    <li class="contact-example">
                        <div class="contact-example__content">
                            <h3>Erreur ou bug sur le site</h3>
                            <p>Vous rencontrez un problème technique ou un comportement inattendu sur le site.</p>
                        </div>
                    </li>

                    <li class="contact-example">
                        <div class="contact-example__content">
                            <h3>Autres demandes</h3>
                            <p>Vous souhaitez avoir des précisions ou pour toutes autres demandes.</p>
                        </div>
                    </li>

                </ul>
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