<?php
include_once '../classes/Database.php';
include_once '../classes/Projet.php';
include_once '../classes/Tache.php';

if(isset($_GET['projet_id'])) {
    $projet_id = $_GET['projet_id'];

    $database = new Database();
    $db = $database->getConnection();

    $tache = new Tache($db);
    $tache->projet_id = $projet_id;

    $stmt_taches = $tache->lireTachesParProjet();

    $total_taches = $stmt_taches->rowCount();
    $taches_terminees = 0;

    while ($tache_row = $stmt_taches->fetch(PDO::FETCH_ASSOC)) {
        if ($tache_row['statut'] == 'Terminé') {  // Correction ici
            $taches_terminees++;
        }
    }

    $statut_projet = ($total_taches > 0 && $taches_terminees == $total_taches) ? 'Terminé' : 'En cours';

    $projet = new Projet($db);
    $projet->id = $projet_id;
    $projet->statut = $statut_projet;

    if($projet->modifierStatut2()) {
        echo json_encode(['success' => true]);
    } else {
        error_log("Erreur lors de la mise à jour du statut du projet avec ID : $projet_id");
        echo json_encode(['success' => false, 'message' => 'Erreur lors de la mise à jour du statut du projet']);
    }
} else {
    error_log('Erreur : ID du projet manquant');
    echo json_encode(['success' => false, 'message' => 'Erreur : ID du projet manquant']);
}
?>
