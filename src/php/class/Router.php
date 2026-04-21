<?php
declare(strict_types=1);


/**
 * Implémentation du Design Patter Repository.
 * Fournit une abstraction de l'accès aux données en séparant
 * la logique métier de la source de données directe.
 * Elle centralise les opérations d'accès aux données.
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

        //Doit commencer par le préfixe
        if (!str_starts_with($this->uri, $prefix)) {
            Reponse::error("Route introuvable", 404);
        }

        //Récupérer après le préfixe
        $path = substr($this->uri, strlen($prefix));
        $segments = array_filter(explode('/', ltrim($path, '/')));
        $segments = array_values($segments);

        if (count($segments) === 0) {
            Reponse::json(['ressources' => array_keys(RESSOURCES)]);
        }

        $resource = $segments[0];
        $spe = $segments[1] ?? null;

        //IMP pour les tables
        if (!array_key_exists($resource, RESSOURCES)) {
            Reponse::error("Resource « $resource » inconnue", 404);
        }

        $target = RESSOURCES[$resource];

        //Valider l'ID : $spe (R+*)
        if ($spe !== null) {
            if (!ctype_alnum($spe) || (int)$spe < 0) {
                Reponse::error("ID $spe invalide", 404);
            }
            targetOne($target, $spe);
        } else {
            targetAll($target);
        }
    }
}


function targetAll(string $target): void
{
    try {
        $db = Database::get();
        $stmt = $db->prepare("SELECT * FROM $target");
        $stmt->execute();
        $rows = $stmt->fetchAll();
        Reponse::json($rows);
    } catch (PDOException $e) {
        Reponse::error("Erreur base de données", 500);
    }
}

function targetOne(string $target, string $id): void
{
    try {
        $db = Database::get();
        $stmt = $db->prepare("SELECT * FROM $target WHERE alim_groupe_code = :id");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        if ($row === false) {
            Reponse::error("Enregistrement introuvable", 404);
        }
        Reponse::json($row);
    } catch (PDOException $e) {
        Reponse::error("Erreur base de données", 500);
    }
}
