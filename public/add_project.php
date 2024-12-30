// public/add_project.php
<?php
session_start();

include_once '../classes/Database.php';
include_once '../classes/Projet.php';

$database = new Database();
$db = $database->getConnection();

$projet = new Projet($db);

$projet->nom = isset($_POST['nom']) ? $_POST['nom'] : die('ERROR: Nom not found.');
$projet->description = isset($_POST['description']) ? $_POST['description'] : die('ERROR: Description not found.');
$projet->date_debut = isset($_POST['date_debut']) ? $_POST['date_debut'] : die('ERROR: Date de début not found.');
$projet->date_fin_prevue = isset($_POST['date_fin_prevue']) ? $_POST['date_fin_prevue'] : die('ERROR: Date de fin prévue not found.');
$projet->statut = isset($_POST['statut']) ? $_POST['statut'] : die('ERROR: Statut not found.');
$projet->responsable_id = isset($_POST['responsable_id']) ? $_POST['responsable_id'] : die('ERROR: Responsable ID not found.');

if ($projet->creer()) {
    header("Location: projects.php");
    exit();
} else {
    header("Location: projects.php?error=add");
    exit();
}
?>
