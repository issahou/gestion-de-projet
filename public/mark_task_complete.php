// public/mark_as_complete.php
<?php
include_once '../classes/Database.php';
include_once '../classes/Tache.php';

$database = new Database();
$db = $database->getConnection();

$tache = new Tache($db);

$tache->id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Task ID not found.');
$tache->statut = 'Terminé';

if ($tache->modifierStatut()) {
    echo "<script>alert('Tâche marquée comme terminée.'); window.location.href='tasks.php';</script>";
} else {
    echo "<script>alert('Impossible de mettre à jour la tâche.'); window.location.href='tasks.php';</script>";
}
?>
