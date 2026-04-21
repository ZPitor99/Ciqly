<?php

declare(strict_types=1);

// Charger le .env (chemin absolu, hors webroot)
require_once __DIR__ . DIRECTORY_SEPARATOR . 'functions_env.php';
loadEnv("C:\Users\gabri\Documents\Ciqly\.env");

/**
 * Installer extension pdo PostgreSQL
 * Connexion PDO PostgreSQL — singleton.
 */
final class Database
{
    private static ?PDO $instance = null;

    // Empêcher l'instanciation directe
    private function __construct()
    {
    }

    /**
     * Créé une instance de prive à la base de donnée PostgreSQL avec les identifiants d'environnement
     * @return PDO Une instance de la prive
     */
    public static function get(): PDO
    {
        if (self::$instance === null) {
            $dsn = sprintf(
                'pgsql:host=%s;dbname=%s',
                $_ENV['DB_HOST'],
                $_ENV['DB_NAME']
            );

            self::$instance = new PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PASS'],[
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        }

        return self::$instance;
    }
}