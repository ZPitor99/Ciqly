<a href="#main-content" class="skip-link">Aller au contenu principal</a>
<header role="banner">
    <nav class="nav" aria-label="Navigation principale">
        <div class="container">
            <div class="nav__inner">
                <a href="/" class="nav__brand" aria-label="Ciqly — Accueil">
                    <span class="nav__brand-dot" aria-hidden="true"></span>
                    CIQLY
                </a>

                <ul class="nav__links" role="list">
                    <li><a href="/">Accueil</a></li>
                    <li><a href="/categories">Groupes</a></li>
                    <li><a href="/assemblage" class="panier-link">
                        <span class="panier-text">Panier
                            <?php if (isset($_SESSION['panier']) && count($_SESSION['panier']) > 0): ?>
                                <span class="badge"><?= count($_SESSION['panier']) ?></span>
                            <?php endif; ?>
                        </span>
                        </a></li>
                    <li><a href="/nutriments">Nutriments</a></li>
                    <li><a href="/analyse">Analyse</a></li>
                    <!--
                    <li><button id="trad" data-fr="Translate" data-en="Traduire">Translate</button></li>
                    -->
                </ul>

                <button class="nav__hamburger" aria-label="Ouvrir le menu" aria-expanded="false">
                    <span></span><span></span><span></span>
                </button>
            </div>
        </div>
    </nav>
</header>

