<?php
// public/edit_project_form.php
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
$projet->id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Project ID not found.');

$stmt = $projet->lireUn();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row) {
    $nom = $row['nom'];
    $description = $row['description'];
    $date_debut = $row['date_debut'];
    $date_fin_prevue = $row['date_fin_prevue'];
    $statut = $row['statut'];
} else {
    die('ERROR: Project not found.');
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
        <a href="indexe.php">Accueil</a>
        <a href="projects.php">Projets</a>
        <a href="tasks.php">Tâches</a>
        <a href="users.php">Utilisateurs</a>
        <a href="reports.php">Rapports</a>
    </nav>

    <div class="container">
        <h1>Modifier un Projet</h1>
        <form action="edit_project.php" method="post" class="form-modifier-projet">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($projet->id, ENT_QUOTES); ?>">
            <div class="form-group">
                <label for="nom">Nom du projet</label>
                <input type="text" name="nom" id="nom" value="<?php echo htmlspecialchars($nom, ENT_QUOTES); ?>" class="input-field">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="input-field textarea-field"><?php echo htmlspecialchars($description, ENT_QUOTES); ?></textarea>
            </div>
            <div class="form-group">
                <label for="date_debut">Date de début</label>
                <input type="date" name="date_debut" id="date_debut" value="<?php echo htmlspecialchars($date_debut, ENT_QUOTES); ?>" class="input-field">
            </div>
            <div class="form-group">
                <label for="date_fin_prevue">Date de fin prévue</label>
                <input type="date" name="date_fin_prevue" id="date_fin_prevue" value="<?php echo htmlspecialchars($date_fin_prevue, ENT_QUOTES); ?>" class="input-field">
            </div>
            <div class="form-group">
                <label for="statut">Statut</label>
                <input type="text" name="statut" id="statut" value="<?php echo htmlspecialchars($statut, ENT_QUOTES); ?>" class="input-field">
            </div>
            <input type="submit" value="Mettre à jour" class="btn">
        </form>
    </div>


</body>
</html>
