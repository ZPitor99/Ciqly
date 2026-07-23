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
    <meta name="description" content="La page que vous recherchez est introuvable. Retournez à l'accueil ou utilisez la navigation pour poursuivre votre visite.">
    <meta name="robots" content="noindex, follow">
    <title>Page introuvable | Ciqly</title>
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

<!-- ===================== CONTENU ===================== -->
<main id="contenu" style="flex: 1; display: flex; align-items: center;">
    <div class="container container--narrow" style="text-align: center;">

        <span class="section-label">Erreur 404</span>

        <h1 class="h1" style="margin-top: 0.25rem;">Page introuvable</h1>

        <p style="max-width: 42ch; margin: 1rem auto 2.5rem;">
            La page que vous recherchez n'existe pas ou a été déplacée.
            Vérifiez l'adresse saisie ou retournez à l'accueil.
        </p>

        <a href="/" class="btn btn--primary">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 12l9-9 9 9" />
                <path d="M5 10v10a1 1 0 0 0 1 1h4v-6h4v6h4a1 1 0 0 0 1-1V10" />
            </svg>
            Retour à l'accueil
        </a>

    </div>
</main>

<!-- ===================== FOOTER ===================== -->
<footer class="footer">
    <div class="container">
        <div class="footer__bottom" style="border-top: none; padding-top: 0;">
            <div class="footer__brand" style="margin-bottom: 0;">
                <span class="footer__brand-dot"></span>
                CIQLY
            </div>
            <span>© <?php echo date('Y'); ?> Ciqly - FRANCE</span>
        </div>
    </div>
</footer>

</body>
<?= $tags->js ?>
</html>