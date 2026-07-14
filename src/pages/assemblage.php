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
            </div>
            <div class="assemblage-form">
                <?php
                if (isset($_SESSION['panier']) && $_SESSION['panier'] != []) {
                    $alim_codes = array_keys($_SESSION['panier']);

                    echo '<form action="/assemblage" method="POST">';

                    for ($i = 0; $i < count($alim_codes); $i++) {
                        $courant = htmlspecialchars($alim_codes[$i]);
                        $data_courant = $_SESSION['panier'][$courant];
                        echo <<<HTML
                        <div class="assemblage-div" id="ligne_{$i}" x-data="{ open: false, qty: {$data_courant['quantite']}  }">
                            <div class="assemblage-ligne">
                            
                                <label for="$courant">{$data_courant["nom"]}</label>
                                <div class="assemblage-champ">
                                  <input type="number"
                                    name="$courant"
                                    id="$courant"
                                    x-model="qty"
                                    min="0"
                                    step="10"
                                    required>
                                <span class="assemblage-unite">g</span>
                                </div>
                                <button type="button" class="arrow-btn" @click="open = ! open" @click.outside="open = false"><b>&vellip;</b></button>                                
                            </div>
                            <div class="menu-dropdown" x-show="open" x-cloak x-transition:enter.duration.400ms x-transition:leave.duration.300ms>
                                <button type="button" @click="panierAction('reset', 'ligne_{$i}', '$courant')">Mettre à Zéro</button>
                                <button type="button" @click="panierAction('supprimer', 'ligne_{$i}', '$courant')">Supprimer</button>
                                <button type="button" @click="panierAction('monter', 'ligne_{$i}', '$courant')">&uarr; Monter</button>
                                <button type="button" @click="panierAction('descendre', 'ligne_{$i}', '$courant')">&darr; Descendre</button>
                            </div>
                        </div>
                        HTML;
                    }
                    echo <<<'HTML'
                    <button type="submit" class="assemblage-submit">Assembler</button>
                    </form>
                    HTML;
                }
                else{
                    $_SESSION['panier'] = [];
                    echo <<<'HTML'
                    <div>
                        <p>Aucun aliment sélectionné.<br>
                        Rechercher un aliment dans la liste des aliments par groupe. <a href="/categories" target="_self" hreflang="fr" class="section-link">Vers la sélection des aliments</a></p>
                        </div>
                    HTML;
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