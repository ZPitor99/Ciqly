<?php

require_once join(DIRECTORY_SEPARATOR, array(__DIR__, '..', 'php', 'class', 'php_vite', 'Manifest.php'));

require_once join(DIRECTORY_SEPARATOR,array(__DIR__,'..','php','utilitaire','reportage.php'));
$journaliste->logJournalRessource(21, null, null, null, null, null);

$vite = new Manifest(
        dev: false,
        manifest_path: __DIR__ . '/../../public/dist/.vite/manifest.json',
        base_path: '/dist/'
);

$tags = $vite->createTags("js/methodologie.js")

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <title>Méthodologie | Ciqly</title>
    <link rel="icon" type="image/x-icon" href="/static/images/icone_ciqly.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="/static/images/icone_ciqly-32.png">
    <link rel="icon" type="image/png" sizes="180x180" href="/static/images/icone_ciqly-180.png">
    <link rel="icon" type="image/svg+xml" href="/static/images/icone_ciqly.svg">
    <?= $tags->css ?>
</head>
<body>

<?php
include(join(DIRECTORY_SEPARATOR, array(__DIR__, '..', 'fragments', 'header.php')));
?>

<!-- ── MAIN ─────────────────────────────────────────────── -->
<main id="main-content">

    <section class="section-header-center bg-gradient">
        <div>
            <h1>Présentation du site</h1>
        </div>
    </section>

    <section class="bg-white">
        <div class="container">
            <h2>Objectifs</h2>
        </div>
    </section>

    <section class="spec bg-sand">
        <div class="container">
            <h2>Technologies du Site</h2>
            <div>
                <h3>Front-end</h3>
                <div class="tech-card">
                    <div class="logo">
                        <img src="/static/images/techno_javascript_html5_css3.png" alt="logo de html5, css3, javascript"
                             loading="lazy">
                    </div>
                    <div class="tech-content">
                        <h4>HTML5 - CSS3 - JavaScript</h4>
                        <p>HTML pour structurer le contenu des pages web, CSS afin de mettre en forme et personnaliser
                            l'apparence et JavaScript pour l'interactivité côté client.</p>
                        <p>
                            <a class="tech-link" href="https://html.spec.whatwg.org/">HTML</a> – Standard maintenu par
                            le WHATWG<br>
                            <a class="tech-link" href="https://www.w3.org/Style/CSS/">CSS</a> – Standard maintenu par le
                            W3C<br>
                            <a class="tech-link" href="https://tc39.es/ecma262/">JavaScript</a> – Standard ECMAScript®
                            maintenu par Ecma International (TC39)
                        </p>
                    </div>
                </div>

                <div class="tech-card">
                    <div class="logo">
                        <img src="/static/images/techno_nodejsdark.png" alt="logo de nodejs" loading="lazy">
                    </div>
                    <div class="tech-content">
                        <h4>Node.js®</h4>
                        <p>Outil de développement afin d'exécuter Javascript</p>
                        <p><a class="tech-link" href="https://nodejs.org/">Node.js®</a> - Marque déposée de l'OpenJS
                            Foundation.</p>
                    </div>
                </div>

                <div class="tech-card">
                    <div class="logo">
                        <img src="/static/images/techno_vite_logo.png" alt="logo de vitejs" loading="lazy">
                    </div>
                    <div class="tech-content">
                        <h4>Vite</h4>
                        <p>Vite pour accélérer le développement, le lancement et la compilation de l'application
                            web.</p>
                        <p><a class="tech-link" href="https://vite.dev/">Vite</a> - Projet open source distribué sous
                            licence MIT.</p>
                    </div>
                </div>

                <div class="tech-card">
                    <div class="logo">
                        <img src="/static/images/techno_alpine_long.png" alt="logo de alpinejs" loading="lazy">
                    </div>
                    <div class="tech-content">
                        <h4>AlpineJS</h4>
                        <p>Framework JavaScript léger pour faciliter l'intégration avec le HTML</p>
                        <p><a class="tech-link" href="https://alpinejs.dev/">AlpineJS</a> - Projet open source distribué
                            sous licence MIT.</p>
                    </div>
                </div>
            </div>


            <div>
                <h3>Back-end</h3>
                <div class="tech-card">
                    <div class="logo">
                        <img src="/static/images/techno_php_logo.png" alt="logo de php" loading="lazy">
                    </div>
                    <div class="tech-content">
                        <h4>PHP</h4>
                        <p>Programmation coté serveur</p>
                        <p><a class="tech-link" href="https://www.php.net/">PHP</a> - Le logo PHP est distribué sous
                            licence Creative Commons Attribution-ShareAlike 4.0.</p>
                    </div>
                </div>


            </div>
            <div>
                <h3>Base de données et traitement de données</h3>
                <div class="tech-card">
                    <div class="logo">
                        <img src="/static/images/techno_elephant.png" alt="logo de postgresql" loading="lazy">
                    </div>
                    <div class="tech-content">
                        <h4>PostgreSQL</h4>
                        <p>Système de gestion de base de données, base de données relationnelle</p>
                        <p><a class="tech-link" href="https://www.postgresql.org/">PostgreSQL</a> - <span lang="en">Postgres, PostgreSQL and the Slonik Logo are trademarks or registered trademarks of the PostgreSQL Community Association of Canada, and used with their permission.</span>
                        </p>
                    </div>
                </div>
                <div class="tech-card">
                    <div class="logo">
                        <img src="/static/images/techno_python_logo.png" alt="logo de python" loading="lazy">
                    </div>
                    <div class="tech-content">
                        <h4>Python®</h4>
                        <p>Utilisé pour la lecture, nettoyage et la normalisation des données de la table Ciqual.</p>
                        <p><a class="tech-link" href="https://www.python.org/">Python</a> - <span lang="en">"Python" and the Python logos are trademarks or registered trademarks of the Python Software Foundation.</span>
                        </p>
                    </div>
                </div>
            </div>

            <div>
                <h3>Serveur Web</h3>
                <div class="tech-card">
                    <div class="logo">
                        <img src="/static/images/techno_nginx_logo.png" alt="logo de nginx" loading="lazy">
                    </div>
                    <div class="tech-content">
                        <h4>Nginx</h4>
                        <p>Serveur Web HTTP</p>
                        <p><a class="tech-link" href="https://nginx.org/">Nginx</a> - F5 Inc principal mainteneur et
                            sponsor de Nginx.</p>
                    </div>
                </div>
                <div class="tech-card">
                    <div class="logo">
                        <img src="/static/images/techno_cloudflarebadge_web.png" alt="logo de cloudflare"
                             loading="lazy">
                    </div>
                    <div class="tech-content">
                        <h4>Cloudflare®</h4>
                        <p>Nom de domaine et technologies réseaux.</p>
                        <p><a class="tech-link" href="https://www.cloudflare.com/">Cloudflare</a> - <span lang="en">Cloudflare, the Cloudflare logo, and Cloudflare Workers are trademarks and/or registered trademarks of Cloudflare, Inc. in the United States and other jurisdictions.</span>
                        </p>
                    </div>
                </div>
                <div class="tech-card">
                    <div class="logo">
                        <img src="/static/images/techno_ovhcloud.png" alt="logo de OVHcloud"
                             loading="lazy">
                    </div>
                    <div class="tech-content">
                        <h4>OVHcloud</h4>
                        <p>Nom de domaine et technologies réseaux.</p>
                        <p><a class="tech-link" href="https://www.ovhcloud.com/fr/">OVHcloud</a> - OVHcloud et le logo OVHcloud sont des marques de appartenant à OVH SAS.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </section>
</main>

<!-- ── FOOTER ─────────────────────────────────────────────── -->
<?php
include(join(DIRECTORY_SEPARATOR, array(__DIR__, '..', 'fragments', 'footer.php')));
?>

</body>
<?= $tags->js ?>
</html>