<?php
require_once join(DIRECTORY_SEPARATOR,array(__DIR__,'..', 'utilitaire','reportage.php'));
require_once join(DIRECTORY_SEPARATOR,array(__DIR__,'..', 'utilitaire','fonctions.php'));

if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = [];
    header('Location: /');
}
else{
    $id = $_POST['alim_code'] ?? null;
    $retour = $_POST['retour'] ?? '/';

    $id = filter_var($id, FILTER_VALIDATE_INT);

    if ($id !== null and is_int($id)) {

        $data_bd = retrouver_aliment($id);
        $alim_code = $data_bd['alim_code'];
        $alim_nom_fr = $data_bd['alim_nom_fr'];

        if (!is_null($alim_code) and !is_null($alim_nom_fr)) {
            if (!in_array($alim_code, array_keys($_SESSION['panier']))) {
                if (count($_SESSION['panier']) > 25) {
                    header('Location: /categories');
                    exit;
                }
                $_SESSION['panier'][htmlspecialchars($alim_code)] = ["nom" => $alim_nom_fr, "quantite" => 100];
                try {
                    $journaliste->logJournalRessource(91, "ajout", $alim_code, null, null, null);
                }catch(Exception $e){
                    error_log($e->getMessage());
                }
            } else{
                unset($_SESSION['panier'][htmlspecialchars($alim_code)]);
                try {
                    $journaliste->logJournalRessource(91, "suppr", $alim_code, null, null, null);
                }catch(Exception $e){
                    error_log($e->getMessage());
                }
            }
        }
    }

    if (str_starts_with($retour, '/')) {
        header('Location: ' . $retour . '#liste_aliments');
    } else {
        header('Location: /');
    }
    exit;
}
header('Location: /404');
exit;