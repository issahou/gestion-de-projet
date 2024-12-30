<?php
class ResponsableDeProjet extends Utilisateur {

    public function __construct($db) {
        parent::__construct($db);
        $this->role = 'responsable_de_projet';
    }

    public function assignerTache($tache_id, $membre_id) {
        // Code pour assigner une tâche à un membre de l'équipe
    }

    public function suivreProgresProjet($projet_id) {
        // Code pour suivre le progrès d'un projet
    }
}
?>
