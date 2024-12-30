// public/add_comment.php
<?php
include_once '../classes/Database.php';
include_once '../classes/Commentaire.php';

$database = new Database();
$db = $database->getConnection();

$commentaire = new Commentaire($db);

$commentaire->tache_id = isset($_POST['tache_id']) ? $_POST['tache_id'] : die('ERROR: Task ID not found.');
$commentaire->contenu = isset($_POST['contenu']) ? $_POST['contenu'] : die('ERROR: Comment content not found.');
$commentaire->date_commentaire = date('Y-m-d H:i:s');  // Définir la date actuelle
$commentaire->auteur_id = isset($_POST['auteur_id']) ? $_POST['auteur_id'] : die('ERROR: Author ID not found.');

if ($commentaire->ajouter()) {
    header("Location: tasks.php");
    exit();
} else {
    header("Location: tasks.php?error=add_comment");
    exit();
}
?>
