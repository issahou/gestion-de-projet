<?php
session_start();

include_once '../classes/Database.php';
include_once '../classes/Utilisateur.php';

$database = new Database();
$db = $database->getConnection();

$utilisateur = new Utilisateur($db);

$utilisateur->id = isset($_POST['id']) ? $_POST['id'] : die('ERROR: User ID not found.');
$utilisateur->nom = isset($_POST['nom']) ? $_POST['nom'] : die('ERROR: Nom not found.');
$utilisateur->email = isset($_POST['email']) ? $_POST['email'] : die('ERROR: Email not found.');
$utilisateur->role = isset($_POST['role']) ? $_POST['role'] : die('ERROR: Role not found.');

$utilisateur->mot_de_passe = isset($_POST['mot_de_passe']) && !empty($_POST['mot_de_passe']) 
    ? password_hash($_POST['mot_de_passe'], PASSWORD_BCRYPT) 
    : $utilisateur->mot_de_passe;

if ($utilisateur->mettreAJour()) {
    header("Location: users.php");
    exit();
} else {
    echo "Erreur lors de la mise à jour des informations.";
}
?>
