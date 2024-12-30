// public/delete_project.php
<?php
include_once '../classes/Database.php';
include_once '../classes/Projet.php';

$database = new Database();
$db = $database->getConnection();

$projet = new Projet($db);
$projet->id = isset($_POST['id']) ? $_POST['id'] : die('ERROR: Project ID not found.');

if ($projet->supprimer()) {
    echo "<script>alert('Projet supprimé avec succès.'); window.location.href='projects.php';</script>";
} else {
    echo "<script>alert('Impossible de supprimer le projet.'); window.location.href='projects.php';</script>";
}
?>
