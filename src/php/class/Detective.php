<?php
declare(strict_types=1);

/**
 * Classe permettant de détecter le matériel et le navigateur à partir du User-Agent HTTP.
 */
final class Detective
{
    private string $userAgent;

    /**
     * Constructeur.
     *
     * @param string $userAgent Le User-Agent HTTP du visiteur.
     */
    public function __construct(string $userAgent)
    {
        $this->userAgent = strtolower($userAgent);
    }

    /**
     * Détermine le type de matériel utilisé par le visiteur.
     *
     * @return string Le type de matériel détecté.
     */
    public function get_materiel(): string
    {
        // Tablettes
        if (
            str_contains($this->userAgent, 'ipad') ||
            str_contains($this->userAgent, 'tablet') ||
            (
                str_contains($this->userAgent, 'android') &&
                !str_contains($this->userAgent, 'mobile')
            )
        ) {
            return 'tablette';
        }

        // Téléphones mobiles
        if (
            str_contains($this->userAgent, 'mobile') ||
            str_contains($this->userAgent, 'iphone') ||
            str_contains($this->userAgent, 'ipod') ||
            str_contains($this->userAgent, 'windows phone')
        ) {
            return 'mobile';
        }

        // Ordinateurs
        if (
            str_contains($this->userAgent, 'windows') ||
            str_contains($this->userAgent, 'macintosh') ||
            str_contains($this->userAgent, 'linux') ||
            str_contains($this->userAgent, 'x11') ||
            str_contains($this->userAgent, 'cros')
        ) {
            return 'ordinateur';
        }

        return 'autre';
    }

    /**
     * Détermine le navigateur utilisé par le visiteur.
     * Si le navigateur n'est pas reconnu, la méthode retourne "autre navigateur".
     *
     * @return string Le nom du navigateur.
     */
    public function get_navigateur(): string
    {

        // Terminal
        if (str_contains($this->userAgent, 'curl/')
            || str_contains($this->userAgent, 'wget/')
            || str_contains($this->userAgent, 'python')
            || str_contains($this->userAgent, 'postman')) {
            return 'terminal';
        }

        // Microsoft Edge
        if (
            str_contains($this->userAgent, 'edg/') ||
            str_contains($this->userAgent, 'edge/')
        ) {
            return 'edge';
        }

        // Opera
        if (
            str_contains($this->userAgent, 'opr/') ||
            str_contains($this->userAgent, 'opera')
        ) {
            return 'opera';
        }

        // Samsung Internet
        if (str_contains($this->userAgent, 'samsungbrowser')) {
            return 'samsung internet';
        }

        // Chrome
        if (
            str_contains($this->userAgent, 'chrome') ||
            str_contains($this->userAgent, 'crios')
        ) {
            return 'chrome';
        }

        // Firefox
        if (
            str_contains($this->userAgent, 'firefox') ||
            str_contains($this->userAgent, 'fxios')
        ) {
            return 'firefox';
        }

        // Safari
        if (
            str_contains($this->userAgent, 'safari')
        ) {
            return 'safari';
        }

        // Internet Explorer
        if (
            str_contains($this->userAgent, 'msie') ||
            str_contains($this->userAgent, 'trident')
        ) {
            return 'internet explorer';
        }

        return 'autre navigateur';
    }
}