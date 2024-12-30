<?php
session_start();

include_once '../classes/Database.php';
include_once '../classes/Utilisateur.php';

$database = new Database();
$db = $database->getConnection();

$utilisateur = new Utilisateur($db);

$utilisateur->nom = isset($_POST['nom']) ? $_POST['nom'] : die('ERROR: Nom not found.');
$utilisateur->email = isset($_POST['email']) ? $_POST['email'] : die('ERROR: Email not found.');
$utilisateur->mot_de_passe = isset($_POST['mot_de_passe']) ? $_POST['mot_de_passe'] : die('ERROR: Mot de passe not found.');
$utilisateur->role = isset($_POST['role']) ? $_POST['role'] : die('ERROR: Role not found.');

if ($utilisateur->creer()) {
    header("Location: users.php");
    exit();
} else {
    echo "Erreur lors de l'ajout de l'utilisateur.";
}
?>
