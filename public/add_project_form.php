<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/style.css">
    <title>Ajouter un Projet</title>
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
        <h1>Ajouter un Projet</h1>
        <form action="add_project.php" method="post" class="form-ajouter-projet">
            <div class="form-group">
                <label for="nom">Nom du projet</label>
                <input type="text" name="nom" id="nom" placeholder="Nom du projet" class="input-field" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" placeholder="Description du projet" class="input-field textarea-field" required></textarea>
            </div>
            <div class="form-group">
                <label for="date_debut">Date de début</label>
                <input type="date" name="date_debut" id="date_debut" class="input-field date-field" required>
            </div>
            <div class="form-group">
                <label for="date_fin_prevue">Date de fin prévue</label>
                <input type="date" name="date_fin_prevue" id="date_fin_prevue" class="input-field date-field" required>
            </div>
            <div class="form-group">
                <label for="statut">Statut</label>
                <select name="statut" id="statut" class="input-field select-field" required>
                    <option value="En cours">En cours</option>
                    <option value="Terminé">Terminé</option>
                </select>
            </div>
            <div class="form-group">
                <label for="responsable_id">Responsable</label>
                <select name="responsable_id" id="responsable_id" class="input-field select-field" required>
                    <?php
                    include_once '../classes/Database.php';
                    include_once '../classes/Utilisateur.php';

                    $database = new Database();
                    $db = $database->getConnection();

                    $utilisateur = new Utilisateur($db);
                    $stmt = $utilisateur->lireTous();

                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='{$row['id']}'>{$row['nom']}</option>";
                    }
                    ?>
                </select>
            </div>
            <input type="submit" value="Ajouter Projet" class="btn">
        </form>
    </div>

    <footer>
        <p>&copy; 2024 Gestion de Projet. Tous droits réservés.</p>
    </footer>
</body>
</html>
