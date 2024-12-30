
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/style.css">
    <title>Ajouter une Tâche</title>
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
        <h1>Ajouter une Tâche</h1>
        
        <form action="add_task.php" method="post" class="form-ajouter-tache">
            <div class="form-group">
                <label for="projet_id">Projet</label>
                <select name="projet_id" id="projet_id" class="input-field">
                    <?php
					
                    include_once '../classes/Database.php';
                    $database = new Database();
                    $db = $database->getConnection();
                    $sql = "SELECT id, nom FROM projets";
                    $result = $db->query($sql);

                    if ($result->rowCount() > 0) {
                        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='{$row['id']}'>{$row['nom']}</option>";
                        }
                    } else {
                        echo "<option value=''>Aucun projet disponible</option>";
                    }
                    ?>
                </select>
            <div class="form-group">
    <label for="nom">Nom de la tâche</label>
    <input type="text" name="nom" id="nom" placeholder="Nom de la tâche" class="input-field">
</div>
<div class="form-group">
    <label for="description">Description</label>
    <textarea name="description" id="description" placeholder="Description de la tâche" class="input-field textarea-field"></textarea>
</div>
<div class="form-group">
    <label for="date_debut">Date de début</label>
    <input type="date" name="date_debut" id="date_debut" class="input-field date-field">
</div>
<div class="form-group">
    <label for="date_fin_prevue">Date de fin prévue</label>
    <input type="date" name="date_fin_prevue" id="date_fin_prevue" class="input-field date-field">
</div>
<div class="form-group">
    <label for="statut">Statut</label>
    <select name="statut" id="statut" class="input-field select-field">
        <option value="À faire">À faire</option>
        <option value="En cours">En cours</option>
        <option value="Terminé">Terminé</option>
        <option value="Bloquée">Bloquée</option>
    </select>
</div>
<div class="form-group">
    <label for="priorite">Priorité</label>
    <select name="priorite" id="priorite" class="input-field select-field">
        <option value="Haute">Haute</option>
        <option value="Moyenne">Moyenne</option>
        <option value="Basse">Basse</option>
    </select>
</div>
<div class="form-group">
    <label for="affectataire_id">ID de l'affectataire</label>
    <input type="text" name="affectataire_id" id="affectataire_id" placeholder="ID de l'affectataire" class="input-field">
</div>
<input type="submit" value="Ajouter Tâche" class="btn">
