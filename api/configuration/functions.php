<?php

function loadEnv(string $path): void
{
    if (!file_exists($path)) {
        throw new RuntimeException(".env introuvable : $path");
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lines as $line) {
        // Ignorer les commentaires
        if (str_starts_with(trim($line), '#')) continue;

        // Séparer clé = valeur
        if (!str_contains($line, '=')) continue;

        [$key, $value] = explode('=', $line, 2);

        $key = trim($key);
        $value = trim($value);

        // Retirer les guillemets optionnels : "valeur" ou 'valeur'
        $value = trim($value, '"\'');

        // Mettre dans $_ENV
        $_ENV[$key] = $value;
    }
}