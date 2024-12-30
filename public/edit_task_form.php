// public/edit_task_form.php
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
        <?php
        include_once '../classes/Database.php';
        include_once '../classes/Tache.php';

        $database = new Database();
        $db = $database->getConnection();

        $tache = new Tache($db);
        $tache->id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Task ID not found.');
        $tache->lireUn();

        ?>
        <form action="edit_task.php" method="post" class="form-modifier-tache">
            <input type="hidden" name="id" value="<?php echo $tache->id; ?>">
            <div class="form-group">
                <label for="nom">Nom de la tâche</label>
                <input type="text" name="nom" id="nom" value="<?php echo htmlspecialchars($tache->nom, ENT_QUOTES); ?>" class="input-field">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="input-field textarea-field"><?php echo htmlspecialchars($tache->description, ENT_QUOTES); ?></textarea>
            </div>
            <div class="form-group">
                <label for="date_debut">Date de début</label>
                <input type="date" name="date_debut" id="date_debut" value="<?php echo $tache->date_debut; ?>" class="input-field date-field">
            </div>
            <div class="form-group">
                <label for="date_fin_prevue">Date de fin prévue</label>
                <input type="date" name="date_fin_prevue" id="date_fin_prevue" value="<?php echo $tache->date_fin_prevue; ?>" class="input-field date-field">
            </div>
            <div class="form-group">
                <label for="date_fin_reelle">Date de fin réelle</label>
                <input type="date" name="date_fin_reelle" id="date_fin_reelle" value="<?php echo $tache->date_fin_reelle; ?>" class="input-field date-field">
            </div>
            <div class="form-group">
                <label for="statut">Statut</label>
                <select name="statut" id="statut" class="input-field select-field">
                    <option value="À faire" <?php if($tache->statut == 'À faire') echo 'selected'; ?>>À faire</option>
                    <option value="En cours" <?php if($tache->statut == 'En cours') echo 'selected'; ?>>En cours</option>
                    <option value="Terminé" <?php if($tache->statut == 'Terminé') echo 'selected'; ?>>Terminé</option>
                    <option value="Bloquée" <?php if($tache->statut == 'Bloquée') echo 'selected'; ?>>Bloquée</option>
                </select>
            </div>
            <div class="form-group">
                <label for="priorite">Priorité</label>
                <select name="priorite" id="priorite" class="input-field select-field">
                    <option value="Haute" <?php if($tache->priorite == 'Haute') echo 'selected'; ?>>Haute</option>
                    <option value="Moyenne" <?php if($tache->priorite == 'Moyenne') echo 'selected'; ?>>Moyenne</option>
                    <option value="Basse" <?php if($tache->priorite == 'Basse') echo 'selected'; ?>>Basse</option>
                </select>
            </div>
            <div class="form-group">
                <label for="affectataire_id">ID de l'affectataire</label>
                <input type="text" name="affectataire_id" id="affectataire_id" value="<?php echo $tache->affectataire_id; ?>" class="input-field">
            </div>
            <div class="form-group">
                <label for="projet_id">Projet</label>
                <select name="projet_id" id="projet_id" class="input-field select-field">
                    <?php
                    $sql = "SELECT id, nom FROM projets";
                    $result = $db->query($sql);

                    if ($result->rowCount() > 0) {
                        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                            $selected = $row['id'] == $tache->projet_id ? 'selected' : '';
                            echo "<option value='{$row['id']}' {$selected}>{$row['nom']}</option>";
                        }
                    } else {
                        echo "<option value=''>Aucun projet disponible</option>";
                    }
                    ?>
                </select>
            </div>
            <input type="submit" value="Modifier Tâche" class="btn">
        </form>
    </div>

    <footer>
        <p>&copy; 2024 Gestion de Projet. Tous droits réservés.</p>
    </footer>
</body>
</html>
