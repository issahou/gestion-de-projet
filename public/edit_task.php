// public/edit_task.php
<?php
include_once '../classes/Database.php';
include_once '../classes/Tache.php';

$database = new Database();
$db = $database->getConnection();

$tache = new Tache($db);

$tache->id = isset($_POST['id']) ? $_POST['id'] : die('ERROR: Task ID not found.');
$tache->nom = $_POST['nom'];
$tache->description = $_POST['description'];
$tache->date_debut = $_POST['date_debut'];
$tache->date_fin_prevue = $_POST['date_fin_prevue'];
$tache->date_fin_reelle = $_POST['date_fin_reelle'];
$tache->statut = $_POST['statut'];
$tache->priorite = $_POST['priorite'];
$tache->affectataire_id = $_POST['affectataire_id'];
$tache->projet_id = $_POST['projet_id'];

if ($tache->modifier()) {
    header("Location: tasks.php");
    exit();
} else {
    header("Location: tasks.php?error=edit");
    exit();
}
?>
