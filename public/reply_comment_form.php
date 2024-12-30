// public/reply_comment_form.php
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/style.css">
    <title>Répondre à un Commentaire</title>
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
        <h1>Répondre à un Commentaire</h1>
        <a href="view_comments.php?task_id=<?php echo $_GET['task_id']; ?>" class="btn">Retour aux Commentaires</a>

        <form action="reply_comment.php" method="post" class="form-ajouter-commentaire">
            <input type="hidden" name="task_id" value="<?php echo $_GET['task_id']; ?>">
            <input type="hidden" name="comment_id" value="<?php echo $_GET['comment_id']; ?>">
            <div class="form-group">
                <label for="contenu">Réponse</label>
                <textarea name="contenu" id="contenu" placeholder="Votre réponse" class="input-field textarea-field"></textarea>
            </div>
            <div class="form-group">
                <label for="auteur_id">ID de l'auteur</label>
                <input type="text" name="auteur_id" id="auteur_id" placeholder="ID de l'auteur" class="input-field">
            </div>
            <input type="submit" value="Répondre" class="btn">
        </form>
    </div>

    <footer>
        <p>&copy; 2024 Gestion de Projet. Tous droits réservés.</p>
    </footer>
</body>
</html>
