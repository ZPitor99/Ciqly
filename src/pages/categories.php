<?php

require_once join(DIRECTORY_SEPARATOR,array(__DIR__,'..','php','class','php_vite','Manifest.php'));

session_start();

$vite = new Manifest(
    dev: false,
    manifest_path: __DIR__.'/../../public/dist/.vite/manifest.json',
    base_path: '/dist/'
);

$tags = $vite->createTags("js/categories.js")

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <title>Ciqly - Catégories</title>
    <link rel="icon" type="image/x-icon" href="/static/images/icone_ciqly.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="/static/images/icone_ciqly-32.png">
    <link rel="icon" type="image/png" sizes="180x180" href="/static/images/icone_ciqly-180.png">
    <link rel="icon" type="image/svg+xml" href="/static/images/icone_ciqly.svg">
    <?= $tags->css ?>
</head>
<body>

<?php
include(join(DIRECTORY_SEPARATOR,array(__DIR__,'..','fragments','header.html')));
?>

<!-- ── MAIN ─────────────────────────────────────────────── -->
<main id="main-content">

    <!-- CATEGORIES -->
    <div x-data="groupe_content">
        <section class="categories section bg-sand" id="categories" aria-labelledby="cat-title">
            <div class="container">
                <div class="section-header">
                    <div>
                        <h1 class="section-title" id="cat-title">Catégories d'aliments</h1>
                    </div>
                </div>

                <div class="cat-grid" role="list">
                    <article class="cat-card" role="article" tabindex="0"
                             :class="{ 'cat-card-selected': groupeSelectionne === 5 }"
                             @click="selectGroupe(5)">
                        <div class="cat-icon" style="background:#E4F4FF">🥩</div>
                        <div class="cat-name">Viandes, Œufs et Poissons</div>
                        <div class="cat-count">791 aliments</div>
                    </article>
                    <article class="cat-card" role="article" tabindex="0"
                             :class="{ 'cat-card-selected': groupeSelectionne === 3 }"
                             @click="selectGroupe(3)">
                        <div class="cat-icon" style="background:#F0FBF0">🍐</div>
                        <div class="cat-name">Fruits, Légumes, Légumineuses et Oléagineux</div>
                        <div class="cat-count">653 aliments</div>
                    </article>
                    <article class="cat-card" role="article" tabindex="0"
                             :class="{ 'cat-card-selected': groupeSelectionne === 2 }"
                             @click="selectGroupe(2)">
                        <div class="cat-icon" style="background:#FAF3EE">🥘</div>
                        <div class="cat-name">Entrées & plats composés</div>
                        <div class="cat-count">407 aliments</div>
                    </article>
                    <article class="cat-card" role="article" tabindex="0"
                             :class="{ 'cat-card-selected': groupeSelectionne === 8 }"
                             @click="selectGroupe(8)">
                        <div class="cat-icon" style="background:#FFF8E4">🍰</div>
                        <div class="cat-name">Produits sucrés</div>
                        <div class="cat-count">361 aliments</div>
                    </article>
                    <article class="cat-card" role="article" tabindex="0"
                             :class="{ 'cat-card-selected': groupeSelectionne === 6 }"
                             @click="selectGroupe(6)">
                        <div class="cat-icon" style="background:#E4F4FF">🥛</div>
                        <div class="cat-name">Produits laitiers</div>
                        <div class="cat-count">356 aliments</div>
                    </article>
                    <article class="cat-card" role="article" tabindex="0"
                             :class="{ 'cat-card-selected': groupeSelectionne === 7 }"
                             @click="selectGroupe(7)">
                        <div class="cat-icon" style="background:#FFF4E6">🍹</div>
                        <div class="cat-name">Eaux et autres boissons</div>
                        <div class="cat-count">325 aliments</div>
                    </article>
                    <article class="cat-card" role="article" tabindex="0"
                             :class="{ 'cat-card-selected': groupeSelectionne === 11 }"
                             @click="selectGroupe(11)">
                        <div class="cat-icon" style="background:#F0FBF0">🧂</div>
                        <div class="cat-name">aides culinaires et ingredients</div>
                        <div class="cat-count">214 aliments</div>
                    </article>
                    <article class="cat-card" role="article" tabindex="0"
                             :class="{ 'cat-card-selected': groupeSelectionne === 4 }"
                             @click="selectGroupe(4)">
                        <div class="cat-icon" style="background:#F0FBF0">🌾</div>
                        <div class="cat-name">Produits céréaliers</div>
                        <div class="cat-count">214 aliments</div>
                    </article>
                    <article class="cat-card" role="article" tabindex="0"
                             :class="{ 'cat-card-selected': groupeSelectionne === 10 }"
                             @click="selectGroupe(10)">
                        <div class="cat-icon" style="background:#FFF8E4">🧈</div>
                        <div class="cat-name">Matières grasses</div>
                        <div class="cat-count">72 aliments</div>
                    </article>
                    <article class="cat-card" role="article" tabindex="0"
                             :class="{ 'cat-card-selected': groupeSelectionne === 12 }"
                             @click="selectGroupe(12)">
                        <div class="cat-icon" style="background:#FAF3EE">🍼</div>
                        <div class="cat-name">Aliments infantiles</div>
                        <div class="cat-count">39 aliments</div>
                    </article>
                    <article class="cat-card" role="article" tabindex="0"
                             :class="{ 'cat-card-selected': groupeSelectionne === 9 }"
                             @click="selectGroupe(9)">
                        <div class="cat-icon" style="background:#F5F0FF">🍧</div>
                        <div class="cat-name">Glaces & Sorbets</div>
                        <div class="cat-count">30 aliments</div>
                    </article>
                    <article class="cat-card" role="article" tabindex="0"
                             :class="{ 'cat-card-selected': groupeSelectionne === 1 }"
                             @click="selectGroupe(1)">
                        <div class="cat-icon" style="background:#E4F4FF">📃</div>
                        <div class="cat-name">Non classifié</div>
                        <div class="cat-count">1 aliments</div>
                    </article>
                </div>
            </div>
        </section>

        <!-- FORMULAIRE -->
        <section class="categories section bg-white" aria-labelledby="cat-title">
            <div class="container">

                <template x-if="groupeSelectionne !== null">
                    <div class="selection-form">
                        <form method="POST" action="/" class="form-inline">

                            <!-- Transmettre le groupe au serveur -->
                            <input type="hidden" name="groupe" :value="groupeSelectionne">

                            <div>
                                <label for="sous_groupe">Sous-groupe</label>
                                <select name="sous_groupe" id="sous_groupe"
                                        x-model="sousGroupeSelectionne"
                                        @change="loadSousSousGroupes()">
                                    <option value="all">Tous</option>
                                    <template x-for="sg in sousGroupesCourant" :key="sg.id">
                                        <option :value="sg.id" x-text="sg.nom"></option>
                                    </template>
                                </select>
                            </div>

                            <div>
                                <label for="sous_sous_groupe">Sous-sous-groupe</label>
                                <select name="sous_sous_groupe" id="sous_sous_groupe"
                                        x-model="sousSousGroupeSelectionne">
                                    <option value="all">Tous</option>
                                    <template x-for="ssg in sousSousGroupesCourant" :key="ssg.id">
                                        <option :value="ssg.id" x-text="ssg.nom"></option>
                                    </template>
                                </select>
                            </div>

                            <button type="submit">Valider</button>
                        </form>
                    </div>
                </template>

            </div>
        </section>
    </div>

</main>

<!-- ── FOOTER ─────────────────────────────────────────────── -->
<?php
include(join(DIRECTORY_SEPARATOR,array(__DIR__,'..','fragments','footer.html')));
?>

</body>
<?= $tags->js ?>
</html>