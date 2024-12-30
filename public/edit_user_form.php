<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/style.css">
    <title>Modifier un Utilisateur</title>
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
        <h1>Modifier un Utilisateur</h1>

        <?php
        include_once '../classes/Database.php';
        include_once '../classes/Utilisateur.php';

        $database = new Database();
        $db = $database->getConnection();

        $utilisateur = new Utilisateur($db);
        $utilisateur->id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: User ID not found.');
        $stmt = $utilisateur->lireUn();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row) {
            $utilisateur->nom = $row['nom'];
            $utilisateur->email = $row['email'];
            $utilisateur->role = $row['role'];
        } else {
            die('ERROR: User not found.');
        }

        $roles = $utilisateur->getRoles();
        ?>

        <form action="edit_user.php" method="post" class="form-modifier-utilisateur">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($utilisateur->id, ENT_QUOTES); ?>">
            <div class="form-group">
                <label for="nom">Nom</label>
                <input type="text" name="nom" id="nom" value="<?php echo htmlspecialchars($utilisateur->nom, ENT_QUOTES); ?>" class="input-field" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($utilisateur->email, ENT_QUOTES); ?>" class="input-field" required>
            </div>
            <div class="form-group">
                <label for="mot_de_passe">Mot de passe</label>
                <input type="password" name="mot_de_passe" id="mot_de_passe" class="input-field">
            </div>
            <div class="form-group">
                <label for="role">Rôle</label>
                <select name="role" id="role" class="input-field select-field" required>
                    <?php
                    foreach ($roles as $role) {
                        $selected = $utilisateur->role == $role['role'] ? 'selected' : '';
                        echo "<option value='{$role['role']}' {$selected}>{$role['role']}</option>";
                    }
                    ?>
                </select>
            </div>
            <input type="submit" value="Modifier Utilisateur" class="btn">
        </form>
    </div>

    <footer>
        <p>&copy; 2024 Gestion de Projet. Tous droits réservés.</p>
    </footer>
</body>
</html>
