<?php

require_once join(DIRECTORY_SEPARATOR,array(__DIR__,'..','php','class','php_vite','Manifest.php'));

session_start();

$vite = new Manifest(
    dev: false,
    manifest_path: __DIR__.'/../../public/dist/.vite/manifest.json',
    base_path: '/dist/'
);

$tags = $vite->createTags("js/assemblage.js");

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <title>Ciqly - Assemblage</title>
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

    <section class="categories section bg-sand" id="categories" aria-labelledby="cat-title">
        <div class="container">
            <div class="section-header">
                <h1 class="section-title" id="cat-title">Les aliments</h1>
                <p><?php var_dump($_POST) ?></p>
            </div>
            <div class="assemblage-form">
                <?php
                if (isset($_SESSION['panier'])){
                    $alim_codes = array_keys($_SESSION['panier']);

                    echo '<form action="/assemblage" method="POST">';

                    for ($i = 0; $i < count($alim_codes); $i++) {
                        $courant = $alim_codes[$i];

                        echo '<div class="assemblage-ligne">';
                        echo '  <label for="'.$courant.'">'.$_SESSION['panier'][$courant]['nom'].'</label>';
                        echo '  <div class="assemblage-champ">';
                        echo '      <input type="number"
                        name="'.$courant.'"
                        id="'.$courant.'"
                        value="'.$_SESSION['panier'][$courant]['quantite'].'"
                        min="0"
                        step="10"
                        required>';
                        echo '      <span class="assemblage-unite">g</span>';
                        echo '  </div>';
                        echo '</div>';
                    }

                    echo '<button type="submit" class="assemblage-submit">Assembler</button>';
                    echo '</form>';
                }
                else{
                    $_SESSION['panier'] = [];
                }
                ?>
            </div>
        </div>
    </section>

    <section>
        <p>Totaux par nutriments</p>
    </section>

</main>

<!-- ── FOOTER ─────────────────────────────────────────────── -->
<?php
include(join(DIRECTORY_SEPARATOR,array(__DIR__,'..','fragments','footer.html')));
?>

</body>
<?= $tags->js ?>
</html>