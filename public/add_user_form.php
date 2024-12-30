<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/style.css">
    <title>Ajouter un Utilisateur</title>
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
        <h1>Ajouter un Utilisateur</h1>
        <form action="add_user.php" method="post" class="form-ajouter-utilisateur">
            <div class="form-group">
                <label for="nom">Nom</label>
                <input type="text" name="nom" id="nom" class="input-field" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="input-field" required>
            </div>
            <div class="form-group">
                <label for="mot_de_passe">Mot de passe</label>
                <input type="password" name="mot_de_passe" id="mot_de_passe" class="input-field" required>
            </div>
            <div class="form-group">
                <label for="role">Rôle</label>
                <select name="role" id="role" class="input-field select-field" required>
                    <?php
                    include_once '../classes/Database.php';
                    include_once '../classes/Utilisateur.php';

                    $database = new Database();
                    $db = $database->getConnection();

                    $utilisateur = new Utilisateur($db);
                    $roles = $utilisateur->getRoles(); // Récupérer les rôles depuis la base de données

                    foreach ($roles as $role) {
                        echo "<option value='{$role['role']}'>{$role['role']}</option>";
                    }
                    ?>
                </select>
            </div>
            <input type="submit" value="Ajouter Utilisateur" class="btn">
        </form>
    </div>

    <footer>
        <p>&copy; 2024 Gestion de Projet. Tous droits réservés.</p>
    </footer>
</body>
</html>
