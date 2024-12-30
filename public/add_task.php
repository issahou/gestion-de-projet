// public/add_task.php
<?php
include_once '../classes/Database.php';
include_once '../classes/Tache.php';

$database = new Database();
$db = $database->getConnection();

$tache = new Tache($db);

$tache->nom = $_POST['nom'];
$tache->description = $_POST['description'];
$tache->date_debut = $_POST['date_debut'];
$tache->date_fin_prevue = $_POST['date_fin_prevue'];
$tache->date_fin_reelle = null;  // Par défaut, la date de fin réelle est null
$tache->statut = $_POST['statut'];
$tache->priorite = $_POST['priorite'];
$tache->affectataire_id = $_POST['affectataire_id'];
$tache->projet_id = $_POST['projet_id'];

if ($tache->ajouter()) {
    header("Location: tasks.php");
    exit();
} else {
    header("Location: tasks.php?error=add");
    exit();
}
?>
