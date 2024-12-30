// public/delete_comment.php
<?php
session_start();
include_once '../classes/Database.php';
include_once '../classes/Commentaire.php';
include_once '../classes/Utilisateur.php';

$database = new Database();
$db = $database->getConnection();

$commentaire = new Commentaire($db);
$commentaire->id = isset($_POST['id']) ? $_POST['id'] : die('ERROR: Comment ID not found.');
$commentaire->lireUn();

$utilisateur = new Utilisateur($db);
$utilisateur->id = $_SESSION['user_id']; // ID de l'utilisateur connecté
$utilisateur->lireUn();

// Vérification des permissions
if ($utilisateur->id == $commentaire->auteur_id || $utilisateur->estChefDeProjet($commentaire->tache_id) || $utilisateur->estAdministrateur()) {
    if ($commentaire->supprimer()) {
        header("Location: view_comments.php?task_id={$commentaire->tache_id}");
        exit();
    } else {
        header("Location: view_comments.php?task_id={$commentaire->tache_id}&error=delete");
        exit();
    }
} else {
    header("Location: view_comments.php?task_id={$commentaire->tache_id}&error=permission");
    exit();
}
?>
