<?php

/**
 * Class permettant d'alimenter les tables de logs.
 */
Final class Journaliste
{
    private PDO $pdo;
    private Detective $detective;
    private bool $estNouvelleSession;

    /**
     * Constructeur.
     *
     * @param PDO $pdo La connection à la bd PostgreSQL
     * @param Detective $detective Le détective en charge du navigateur et du matériel
     */
    public function __construct(PDO $pdo, Detective $detective){
        $this->pdo = $pdo;
        $this->detective = $detective;
        $cookieName = session_name();

        $this->estNouvelleSession = !isset($_COOKIE[$cookieName]);

        session_start();

        if ($this->estNouvelleSession) {
            $this->logJounalSession();
        }
    }

    /**
     * Créer un enregistrement dans le journal des sessions.
     *
     * @return void
     */
    private function logJounalSession(): void{
        $nav = $this->detective->get_navigateur();
        $mat = $this->detective->get_materiel();
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO ciqly_logs.journal_sess(session_id, type_nav, type_mat)
                    VALUES (:id, :nav, :mat)");
            $stmt->execute([
                'id' => session_id(),
                'nav' => $nav,
                'mat' => $mat
            ]);
        }catch (Exception $e){
            error_log($e->getMessage());
        }
    }

    /**
     * Ajoute un enregistrement dans le journal des ressources.
     *
     * @param int $cpage Le code de la page
     * @param string|null $act Le type de l'action
     * @param string|null $calim L'alim_code de l'aliment concerné par l'action
     * @param string|null $rech La chaine recherchée
     * @param array|null $panier_code Le panier des codes
     * @param array|null $panier_coef Le parnier des coefs
     * @return void
     */
    public function logJournalRessource(int $cpage, ?string $act, ?string $calim, ?string $rech, ?array $panier_code, ?array $panier_coef): void{

        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO ciqly_logs.journal_ress(session_id, code_page, nat_act, alim_code, txt_rech)
                    VALUES (:id, :cpage, :act, :calim, :rech)
                    RETURNING id_jress");

            $stmt->bindValue(":id", session_id(), PDO::PARAM_INT);
            $stmt->bindValue(":cpage", $cpage, PDO::PARAM_INT);
            if (is_null($act)){
                $stmt->bindValue(":act",  null, PDO::PARAM_NULL);
            }
            else{
                $stmt->bindValue(":act", $act, PDO::PARAM_STR);
            }
            if (is_null($calim)){
                $stmt->bindValue(":calim",  null, PDO::PARAM_NULL);
            }
            else{
                $stmt->bindValue(":calim", $calim, PDO::PARAM_INT);
            }
            if (is_null($rech)){
                $stmt->bindValue(":rech",  null, PDO::PARAM_NULL);
            }
            else{
                $stmt->bindValue(":rech", $rech, PDO::PARAM_STR);
            }

            $stmt->execute();
            $id_jress = $stmt->fetchColumn();

            if ($act == "asbl" and !is_null($panier_code) and $panier_code != [] and !is_null($panier_coef) and $panier_coef != []){
                $this->logJournalAssemblage($id_jress, $panier_code, $panier_coef);
            }

        }catch (Exception $e){
            error_log($e->getMessage());
        }
    }

    /**
     * Ajoute les enregistrements du panier dans le journal d'assemblage.
     *
     * @param int $id_jress L'identifiant de l'action d'assemblage
     * @param array $panier_code Le panier des codes
     * @param array $panier_coef Le parnier des coefs
     * @return void
     */
    public function logJournalAssemblage(int $id_jress, array $panier_code, array $panier_coef): void{
        if (count($panier_code) === count($panier_coef)){

            $stmt = $this->pdo->prepare("
                INSERT INTO ciqly_logs.journal_asbl
                    VALUES (:id, :pos, :calim, ROUND(CAST(:qte AS numeric)*100, 0)::smallint)");

            $this->pdo->beginTransaction();
            try {
                for($i = 0; $i < count($panier_code); $i++){
                    $stmt->execute([
                        'id' => $id_jress,
                        'pos' => $i,
                        'calim' => $panier_code[$i],
                        'qte' => $panier_coef[$i]
                    ]);
                }
                $this->pdo->commit();
            }catch (Exception $e){
                $this->pdo->rollBack();
                error_log($e->getMessage());
            }
        }
    }

}