<?php
class MembreEquipe extends Utilisateur {

    public function __construct($db) {
        parent::__construct($db);
        $this->role = 'membre_equipe';
    }

    public function mettreAJourTache($tache_id, $statut) {
        // Code pour mettre à jour le statut d'une tâche
    }
}
?>
