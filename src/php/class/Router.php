<?php
declare(strict_types=1);
require_once join(DIRECTORY_SEPARATOR, array(__DIR__, '..', 'rpc_function.php'));
require_once join(DIRECTORY_SEPARATOR, array(__DIR__, '..', 'config.php'));

/**
 * Mise en place d'une API RPC
 */
final class Router
{
    private string $uri;

    public function __construct(string $uri)
    {
        $this->uri = rtrim($uri, '/');
    }

    public function dispatch(): void
    {
        $prefix = API_PREFIX;

        // Doit commencer par le préfixe
        if (!str_starts_with($this->uri, $prefix)) {
            Reponse::error('Route introuvable', 404);
        }

        // Seul POST est autorisé pour le RPC
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Reponse::error('Méthode HTTP non autorisée', 405);
        }

        $input = $this->getJsonBody();

        if (!isset($input['method']) || !is_string($input['method'])) {
            Reponse::error("Champ 'method' manquant ou invalide");
        }

        $method = $input['method'];
        $params = $input['params'] ?? [];

        if (!is_array($params)) {
            Reponse::error("Champ 'params' invalide (objet attendu)");
        }

        // La méthode doit exister dans la table de correspondance
        if (!array_key_exists($method, RESSOURCES)) {
            Reponse::error("Méthode '$method' inconnue", 404);
        }

        $fonction = RESSOURCES[$method];

        if (!function_exists($fonction)) {
            Reponse::error("Handler '$fonction' non implémenté", 500);
        }

        try {
            $pdo    = Database::get();
            $result = call_user_func($fonction, $pdo, $params);
            Reponse::json(['result' => $result]);
        } catch (InvalidArgumentException $e) {
            Reponse::error($e->getMessage());
        } catch (PDOException $e) {
            //logs servers
            error_log($e->getMessage());
            Reponse::error('Erreur base de données', 500);
        } catch (Throwable $e) {
            //logs servers
            error_log($e->getMessage());
            Reponse::error('Erreur serveur', 500);
        }
    }

    /**
     * Lit et décode le corps JSON de la requête.
     * Vérifie la taille du body POST : file_get_contents('php://input') sans limite peut être un vecteur de DoS
     * @return array<string, mixed>
     */
    private function getJsonBody(): array
    {
        $maxSize = 1024 * 16; // 16 Ko, ajustable selon tes besoins

        $contentLength = (int)($_SERVER['CONTENT_LENGTH'] ?? 0);

        if ($contentLength > $maxSize) {
            Reponse::error('Corps de requête trop volumineux', 413);
        }

        $raw = file_get_contents('php://input');

        if ($raw === false || $raw === '') {
            Reponse::error('Corps de requête vide', 400);
        }

        // Double vérification (CONTENT_LENGTH peut être absent/falsifié)
        if (strlen($raw) > $maxSize) {
            Reponse::error('Corps de requête trop volumineux', 413);
        }

        $data = json_decode($raw, true);

        if (json_last_error() !== JSON_ERROR_NONE || !is_array($data)) {
            Reponse::error('JSON invalide : ' . json_last_error_msg(), 400);
        }

        return $data;
    }
}