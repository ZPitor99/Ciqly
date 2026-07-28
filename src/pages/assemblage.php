<?php

require_once join(DIRECTORY_SEPARATOR,array(__DIR__,'..','php','class','php_vite','Manifest.php'));

session_start();

$vite = new Manifest(
    dev: false,
    manifest_path: __DIR__.'/../../public/dist/.vite/manifest.json',
    base_path: '/dist/'
);

$tags = $vite->createTags("js/assemblage.js");

$message = null;

if (!isset($_SESSION['calcul_assemblage'])){
    $_SESSION['calcul_assemblage'] = false;
}
else {
    if (!isset($_SESSION['graphique1']) || !isset($_SESSION['graphique2']) || $_SESSION['graphique1'] == [] || $_SESSION['graphique2'] == []) {
        $message = 'Certaines données n\'ont pas pu être chargées, certains affichages peuvent être affectés';
    }
    else {
        $donnees = $_SESSION['graphique2'];
        $donnees_graphique = htmlspecialchars(json_encode($donnees), ENT_QUOTES, "UTF-8");
        $donnees_eau = $_SESSION['graphique1'];
        $donnees_graphique_eau = htmlspecialchars(json_encode($donnees_eau), ENT_QUOTES, "UTF-8");
    }

    if (!isset($_SESSION['tab_stat']['nb_aliment']) || empty($_SESSION['tab_stat'])) {
        $nb_aliment = "&mdash;";
    }
    else {
        $nb_aliment = $_SESSION['tab_stat']['nb_aliment'];
    }
    if (!isset($_SESSION['tab_stat']['distinct_grp']) || empty($_SESSION['tab_stat'])){
        $distinct_grp = "&mdash;";
    }
    else{
        $distinct_grp = $_SESSION['tab_stat']['distinct_grp'];
    }
    if (!isset($_SESSION['tab_stat']['concat_conf']) || empty($_SESSION['tab_stat'])){
        $concat_conf = "Non définie";
    }
    else{
        $concat_conf = $_SESSION['tab_stat']['concat_conf'];
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <title>Assemblage | Ciqly</title>
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
                <h1 class="section-title" id="cat-title">Mon panier d'aliments</h1>
            </div>
            <div class="assemblage-form">
                <?php
                if (isset($_SESSION['panier']) && $_SESSION['panier'] != []) {
                    $alim_codes = array_keys($_SESSION['panier']);

                    echo '<form action="/action_calcul_assemblage" method="POST" x-data="{ quantites: {} }">';

                    for ($i = 0; $i < count($alim_codes); $i++) {
                        $courant = htmlspecialchars($alim_codes[$i]);
                        $data_courant = $_SESSION['panier'][$courant];
                        echo <<<HTML
                        <div class="assemblage-div" id="ligne_{$i}" x-data="{ open: false }">
                            <div class="assemblage-ligne">
                            
                                <label for="$courant">{$data_courant["nom"]}</label>
                                <div class="assemblage-champ">
                                  <input type="number"
                                    name="$courant"
                                    id="$courant"
                                    x-model.number="quantites['$courant']"
                                    x-init="quantites['$courant'] = {$data_courant['quantite']}"
                                    min="0"
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
                    <div class="assemblage-footer">
                        <button type="submit" name="assemblage" class="assemblage-submit">Assembler</button>
                        <p>Somme des aliments : <span x-text="Object.values(quantites).reduce((total, v) => total + (Number(v) || 0), 0)"></span>g</p>
                    </div>    
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

    <?php
    if ($_SESSION['panier'] != [] && $_SESSION['calcul_assemblage'] === true) {
        $_SESSION['calcul_assemblage'] = false;
        echo <<<HTML
        <section class="section">
            <div class="container">
                <div class="section-header">
                    <h2>Résultat</h2>
                </div>   
            </div>     
            <div class="container data-table">
                <table>
                    <caption>Statistiques général</caption>
                    <thead>
                        <tr>
                            <th>Données</th>
                            <th>Valeur</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Nombre d'aliments <span title="Définition : Nombre total d'aliments sélectionnés.">&#9432;</span></td>
                            <td id="somme">$nb_aliment</td>
                        </tr>
                        <tr>
                            <td>Indice de diversité <span title="Définition : proportion de catégories d'aliments distinctes présentes dans le panier.">&#9432;</span></td>
                            <td id="diversite">$distinct_grp</td>
                        </tr>
                        <tr>
                            <td>Score de Fiabilité des graphiques <span title="Définition : moyenne des scores de confiance attribués à chaque source des données utilisées pour les graphiques. (A, B, C ou D)">&#9432;</span></td>
                            <td id="fiabilite">$concat_conf</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="container container--narrow">
                <div class="card">
                    <div class="card__body">
                        <span class="section-label">Résultat du panier</span>
                        <h3>Répartition nutritionnelle</h3>
                        <div id="chart" data-graphique='{$donnees_graphique}'></div>
                    </div>
                </div>
            </div>
            <div class="container container--narrow">
                <div class="card">
                    <div class="card__body">
                        <span class="section-label">Résultat du panier</span>
                        <h3>Proportion aqueuse d'assemblage</h3>
                        <div id="chart-eau" data-graphique='{$donnees_graphique_eau}'></div>
                    </div>
                </div>
            </div>
            <div class="container" x-data="{ open_mineraux: true, open_vitamines: true}">
                <div>
                    <button type="button" @click="open_mineraux = ! open_mineraux">
                        Les minéreaux
                        <span x-show="open_mineraux">⌃</span>
                        <span x-show="!open_mineraux">⌄</span>
                    </button>                                
                    <div class="menu-dropdown" x-show="open_mineraux" x-cloak x-transition:enter.duration.400ms x-transition:leave.duration.300ms>
                            
                    </div>
                </div>  
                <div>
                    <button type="button" @click="open_vitamines = ! open_vitamines">
                        Les vitamines
                        <span x-show="open_vitamines">⌃</span>
                        <span x-show="!open_vitamines">⌄</span>
                    </button>                                
                    <div class="menu-dropdown" x-show="open_vitamines" x-cloak x-transition:enter.duration.400ms x-transition:leave.duration.300ms>
                            
                    </div>
                </div>        
                
            </div>
            <div class="container mt-3">
                <p class="text-muted small">
                Les valeurs nutritionnelles affichées sont des estimations calculées à partir de la table CIQUAL de l'ANSES et peuvent différer des valeurs réelles.
                <a href="/mentions_legales#av-calcul-val-nutrition" target="_self" hreflang="fr" class="section-link">En savoir plus</a>.
                </p>
                <p class="text-muted">
                Les quotas journaliers présentés sont des repères basés sur une alimentation de 2 000 kcal/jour.
                Les besoins réels varient selon l'âge, le sexe, le poids, la taille, l'activité physique et les objectifs de chacun.
                Pour en savoir plus et obtenir des explications détaillées, consultez notre page <a href="/nutriments" target="_self" hreflang="fr" class="section-link">Nutriments</a>.
                </p>
            </div>
        </section>
        HTML;
        echo $message;
    }
    ?>


</main>

<!-- ── FOOTER ─────────────────────────────────────────────── -->
<?php
include(join(DIRECTORY_SEPARATOR,array(__DIR__,'..','fragments','footer.php')));
?>

</body>
<?= $tags->js ?>
</html>