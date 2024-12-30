// public/view_comments.php
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/style.css">
    <title>Commentaires</title>
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
        <h1>Commentaires</h1>

        <?php
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header("Location: login.php");
            exit();
        }

        include_once '../classes/Database.php';
        include_once '../classes/Commentaire.php';
        include_once '../classes/Utilisateur.php';

        $database = new Database();
        $db = $database->getConnection();

        $commentaire = new Commentaire($db);
        $commentaire->tache_id = isset($_GET['task_id']) ? $_GET['task_id'] : die('ERROR: Task ID not found.');

        $stmt = $commentaire->lireCommentairesParTache();

        $utilisateur = new Utilisateur($db);
        $utilisateur->id = $_SESSION['user_id']; // ID de l'utilisateur connecté
        $user_data = $utilisateur->lireUn();

        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                echo "<div class='comment'>";
                echo "<div class='icon'><img src='../assets/comment-icon.png' alt='Comment Icon'></div>";
                echo "<div class='content'>";
                echo "<span class='author'>{$auteur}</span>";
                echo "<span class='date'> - {$date_commentaire}</span>";
                echo "<p>{$contenu}</p>";
                echo "<div class='comment-buttons'>";
                echo "<a href='reply_comment_form.php?task_id={$commentaire->tache_id}&comment_id={$id}' class='btn'>Répondre</a>";

                // Vérification des permissions pour afficher le bouton "Supprimer"
                if ($utilisateur->id == $auteur_id || $utilisateur->estChefDeProjet($commentaire->tache_id) || $utilisateur->estAdministrateur()) {
                    echo "<form action='delete_comment.php' method='post' style='display:inline;'>
                              <input type='hidden' name='id' value='{$id}'>
                              <input type='hidden' name='task_id' value='{$commentaire->tache_id}'>
                              <input type='submit' value='Supprimer' class='btn'>
                          </form>";
                }

                echo "</div>"; // Fin de comment-buttons
                echo "</div>"; // Fin de content
                echo "</div>"; // Fin de comment
            }
        } else {
            echo "<p>Aucun commentaire trouvé.</p>";
        }
        ?>

        <div class="button-group">
            <a href="tasks.php" class="btn">Retour aux Tâches</a>
            <a href="add_comment_form.php?task_id=<?php echo $commentaire->tache_id; ?>" class="btn">Ajouter un Commentaire</a>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 Gestion de Projet. Tous droits réservés.</p>
    </footer>
</body>
</html>
