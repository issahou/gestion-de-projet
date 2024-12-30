// public/add_comment_form.php
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/style.css">
    <title>Ajouter un Commentaire</title>
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
        <h1>Ajouter un Commentaire</h1>
        <form action="add_comment.php" method="post" class="form-ajouter-commentaire">
            <input type="hidden" name="tache_id" value="<?php echo $_GET['task_id']; ?>">
            <div class="form-group">
                <label for="contenu">Commentaire</label>
                <textarea name="contenu" id="contenu" placeholder="Votre commentaire" class="input-field textarea-field"></textarea>
            </div>
            <div class="form-group">
                <label for="auteur_id">ID de l'auteur</label>
                <input type="text" name="auteur_id" id="auteur_id" placeholder="ID de l'auteur" class="input-field">
            </div>
            <input type="submit" value="Ajouter Commentaire" class="btn">
        </form>
    </div>

    <footer>
        <p>&copy; 2024 Gestion de Projet. Tous droits réservés.</p>
    </footer>
</body>
</html>
