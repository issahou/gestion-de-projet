<?php
include_once '../classes/Database.php';
include_once '../classes/Utilisateur.php';

$database = new Database();
$db = $database->getConnection();

$utilisateur = new Utilisateur($db);
$utilisateur->creerUtilisateur('admin@example.com', 'adminpassword', 'administrateur');
?>
