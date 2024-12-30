// public/delete_task.php
<?php
include_once '../classes/Database.php';
include_once '../classes/Tache.php';

$database = new Database();
$db = $database->getConnection();

$tache = new Tache($db);
$tache->id = isset($_POST['id']) ? $_POST['id'] : die('ERROR: Task ID not found.');

if ($tache->supprimer()) {
    header("Location: tasks.php");
    exit();
} else {
    header("Location: tasks.php?error=delete");
    exit();
}
?>
