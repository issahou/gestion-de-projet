<?php
session_start();

include_once '../classes/Database.php';
include_once '../classes/Utilisateur.php';
include_once '../classes/Administrateur.php';
include_once '../classes/ResponsableDeProjet.php';
include_once '../classes/MembreEquipe.php';

$database = new Database();
$db = $database->getConnection();

$utilisateur = new Utilisateur($db);
$utilisateur->id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: User ID not found.');

if ($utilisateur->supprimer()) {
    header("Location: users.php");
    exit();
} else {
    echo "Erreur lors de la suppression de l'utilisateur.";
}
?>
