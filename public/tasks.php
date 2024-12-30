<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/style.css">
    <title>Tâches</title>
    <style>
        .floating-btn {
            position: fixed;
            top: 60px; /* Ajustez cette valeur pour changer la distance par rapport au haut */
            left: 10px;
            background-color: #007BFF;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            z-index: 1000;
        }
    </style>
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
        <h1>
            Liste des Tâches
            <button class="floating-btn" onclick="window.location.href='add_task_form.php'">Ajouter</button>
        </h1>

        <?php
        if (isset($_GET['error'])) {
            if ($_GET['error'] == 'add') {
                echo "<p style='color:red;'>Erreur lors de l'ajout de la tâche.</p>";
            } elseif ($_GET['error'] == 'edit') {
                echo "<p style='color:red;'>Erreur lors de la modification de la tâche.</p>";
            } elseif ($_GET['error'] == 'delete') {
                echo "<p style='color:red;'>Erreur lors de la suppression de la tâche.</p>";
            } elseif ($_GET['error'] == 'complete') {
                echo "<p style='color:red;'>Erreur lors de la mise à jour de la tâche.</p>";
            }
        }

        include_once '../classes/Database.php';
        include_once '../classes/Tache.php';

        $database = new Database();
        $db = $database->getConnection();

        $tache = new Tache($db);
        $stmt = $tache->lireTous();
        $num = $stmt->rowCount();

        if ($num > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                echo "<div class='card'>";
                echo "<h2>{$nom}</h2>";
                echo "<p>Description : {$description}</p>";
                echo "<p>Date de début : {$date_debut}</p>";
                echo "<p>Date de fin prévue : {$date_fin_prevue}</p>";
                echo "<p>Date de fin réelle : {$date_fin_reelle}</p>";
                echo "<p>Statut : {$statut}</p>";
                echo "<p>Priorité : {$priorite}</p>";
                echo "<p>Affectataire : {$affectataire_id}</p>";
                echo "<form action='edit_task_form.php' method='get' style='display:inline;'>
                          <input type='hidden' name='id' value='{$id}'>
                          <input type='submit' value='Modifier' class='btn'>
                      </form>";
                echo "<form action='delete_task.php' method='post' style='display:inline;'>
                          <input type='hidden' name='id' value='{$id}'>
                          <input type='submit' value='Supprimer' class='btn'>
                      </form>";
                echo "<form action='mark_as_complete.php' method='post' style='display:inline;'>
                          <input type='hidden' name='id' value='{$id}'>
                          <input type='submit' value='Marquer comme Terminée' class='btn'>
                      </form>";
                echo "<a href='view_comments.php?task_id={$id}' class='btn'>Voir Commentaires</a>";
                echo "<a href='add_comment_form.php?task_id={$id}' class='btn'>Ajouter un Commentaire</a>";
                echo "</div>";
            }
        } else {
            echo "<p>Aucune tâche trouvée.</p>";
        }
        ?>

       

</body>
</html>
