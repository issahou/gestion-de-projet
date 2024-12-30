<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include_once '../classes/Database.php';
include_once '../classes/Projet.php';

$database = new Database();
$db = $database->getConnection();

$projet = new Projet($db);

if ($_POST) {
    $projet->id = htmlspecialchars(strip_tags($_POST['id']));
    $projet->nom = htmlspecialchars(strip_tags($_POST['nom']));
    $projet->description = htmlspecialchars(strip_tags($_POST['description']));
    $projet->date_debut = htmlspecialchars(strip_tags($_POST['date_debut']));
    $projet->date_fin_prevue = htmlspecialchars(strip_tags($_POST['date_fin_prevue']));
    $projet->statut = htmlspecialchars(strip_tags($_POST['statut']));
    $projet->responsable_id = $_SESSION['user_id']; // Utilisateur actuel comme responsable

    if ($projet->modifier()) {
        $_SESSION['message'] = "Projet mis à jour avec succès.";
        header("Location: projects.php");
        exit();
    } else {
        $_SESSION['error'] = "Impossible de mettre à jour le projet.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/style.css">
    <title>Modifier un Projet</title>
</head>
<body>
    <nav>
        <a href="index.php">Accueil</a>
        <a href="projects.php">Projets</a>
        <a href="tasks.php">Tâches</a>
        <a href="users.php">Utilisateurs</a>
        <a href="reports.php">Rapports</a>
    </nav>

    <div class="container">
        <h1>Modifier un Projet</h1>
        <?php
        if (isset($_SESSION['error'])) {
            echo "<div class='error-message'>" . $_SESSION['error'] . "</div>";
            unset($_SESSION['error']);
        }
        ?>
    </div>
</body>
</html>
