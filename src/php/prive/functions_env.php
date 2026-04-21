<?php

/**
 * Met dans $_ENV, la variable d'environnement de prive à la base de donnée.
 * (Utilisateur en lecture seul)
 * Lève une exception si introuvable.
 * @param string $path la variable d'environnement
 * @return void
 */
function loadEnv(string $path): void
{
    if (!file_exists($path)) {
        throw new RuntimeException(".env introuvable : $path");
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lines as $line) {
        // Ignorer les commentaires
        if (str_starts_with(trim($line), '#')) continue;
        if (!str_contains($line, '=')) continue;

        [$key, $value] = explode('=', $line, 2);

        $key = trim($key);
        $value = trim($value);

        $value = trim($value, '"\'');

        $_ENV[$key] = $value;
    }
}