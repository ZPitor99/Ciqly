<?php

/**
 * Classe originale provenant de mindplay\php-vite
 * Source: https://github.com/mindplay-dk/php-vite
 * Contributeurs: Rasmus Schultz, Thomas Müller, Brian Angulo
 * Intégré et modifié en avril 2026
 * Licence: Mozilla Public License 2.0
 */

/**
 * @see Manifest::createTags()
 */
class Tags
{
    public function __construct(
        public readonly string $preload = '',
        public readonly string $css = '',
        public readonly string $js = ''
    ) {
    }
}
