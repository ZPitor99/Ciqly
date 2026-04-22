<?php
declare(strict_types=1);

final class Reponse
{

    /**
     * Fonction de structuration de la réponse au format JSON (success)
     * @param mixed $data
     * @param int $statusCode
     * @return never
     */
    public static function json(mixed $data, int $statusCode = 200): never
    {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit(0);
    }

    /**
     * Fonction de structuration de la réponse au format JSON (error)
     * @param string $message
     * @param int $statusCode
     * @return never
     */
    public static function error(string $message, int $statusCode = 400): never
    {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode([
            'error' => $message,
            'code' => $statusCode
        ], JSON_UNESCAPED_UNICODE);
        exit(0);
    }
}