<?php
include_once '../classes/Database.php';
include_once '../classes/Tache.php';

$database = new Database();
$db = $database->getConnection();

$task_id = isset($_POST['id']) ? $_POST['id'] : die('ERROR: Task ID not found.');

$tache = new Tache($db);
$tache->id = $task_id;
$tache->lireUn();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_task'])) {
    $tache->nom = $_POST['nom'] ?? $tache->nom;
    $tache->description = $_POST['description'] ?? $tache->description;
    $tache->date_debut = $_POST['date_debut'] ?? $tache->date_debut;
    $tache->date_fin_prevue = $_POST['date_fin_prevue'] ?? $tache->date_fin_prevue;
    $tache->date_fin_reelle = $_POST['date_fin_reelle'] ?? $tache->date_fin_reelle;
    $tache->statut = $_POST['statut'] ?? $tache->statut;
    $tache->priorite = $_POST['priorite'] ?? $tache->priorite;
    $tache->affectataire_id = $_POST['affectataire_id'] ?? $tache->affectataire_id;

    if ($tache->modifier()) {
        header("Location: tasks.php");
        exit();
    } else {
        echo "Erreur lors de la mise à jour de la tâche.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/style.css">
    <title>Modifier une Tâche</title>
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
        <h1>Modifier une Tâche</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="hidden" name="id" value="<?php echo $task_id; ?>">
            <div class="form-group">
                <label for="nom">Nom</label>
                <input type="text" name="nom" id="nom" value="<?php echo htmlspecialchars($tache->nom ?? ''); ?>" class="input-field" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="input-field textarea-field" required><?php echo htmlspecialchars($tache->description ?? ''); ?></textarea>
            </div>
            <div class="form-group">
                <label for="date_debut">Date de début</label>
                <input type="date" name="date_debut" id="date_debut" value="<?php echo htmlspecialchars($tache->date_debut ?? ''); ?>" class="input-field date-field" required>
            </div>
            <div class="form-group">
                <label for="date_fin_prevue">Date de fin prévue</label>
                <input type="date" name="date_fin_prevue" id="date_fin_prevue" value="<?php echo htmlspecialchars($tache->date_fin_prevue ?? ''); ?>" class="input-field date-field" required>
            </div>
            <div class="form-group">
                <label for="date_fin_reelle">Date de fin réelle</label>
                <input type="date" name="date_fin_reelle" id="date_fin_reelle" value="<?php echo htmlspecialchars($tache->date_fin_reelle ?? ''); ?>" class="input-field date-field">
            </div>
            <div class="form-group">
                <label for="statut">Statut</label>
                <select name="statut" id="statut" class="input-field select-field" required>
                    <option value="À faire" <?php echo ($tache->statut == 'À faire') ? 'selected' : ''; ?>>À faire</option>
                    <option value="En cours" <?php echo ($tache->statut == 'En cours') ? 'selected' : ''; ?>>En cours</option>
                    <option value="Terminé" <?php echo ($tache->statut == 'Terminé') ? 'selected' : ''; ?>>Terminé</option>
                    <option value="Bloquée" <?php echo ($tache->statut == 'Bloquée') ? 'selected' : ''; ?>>Bloquée</option>
                </select>
            </div>
                        </div>
            <div class="form-group">
                <label for="priorite">Priorité</label>
                <select name="priorite" id="priorite" class="input-field select-field" required>
                    <option value="Haute" <?php echo ($tache->priorite == 'Haute') ? 'selected' : ''; ?>>Haute</option>
                    <option value="Moyenne" <?php echo ($tache->priorite == 'Moyenne') ? 'selected' : ''; ?>>Moyenne</option>
                    <option value="Basse" <?php echo ($tache->priorite == 'Basse') ? 'selected' : ''; ?>>Basse</option>
                </select>
            </div>
            <div class="form-group">
                <label for="affectataire_id">Affectataire</label>
                <input type="text" name="affectataire_id" id="affectataire_id" value="<?php echo htmlspecialchars($tache->affectataire_id ?? ''); ?>" class="input-field">
            </div>
            <input type="submit" name="update_task" value="Mettre à jour" class="btn">
        </form>
    </div>

    <footer>
        <p>&copy; 2024 Gestion de Projet. Tous droits réservés.</p>
    </footer>
</body>
</html>
