<?php
include_once '../classes/Database.php';
include_once '../classes/Projet.php';
include_once '../classes/Tache.php';

$database = new Database();
$db = $database->getConnection();

$query = isset($_POST['query']) ? htmlspecialchars(strip_tags($_POST['query'])) : '';

$projet = new Projet($db);
$tache = new Tache($db);

$projets = $projet->rechercher($query);
$taches = $tache->rechercher($query);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/style.css">
    <title>Résultats de recherche</title>
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
        <h1>Résultats de recherche pour "<?php echo $query; ?>"</h1>

        <h2>Projets</h2>
        <?php
        if ($projets->rowCount() > 0) {
            while ($row = $projets->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                echo "<div class='card'>";
                echo "<h2>{$nom}</h2>";
                echo "<p>Description : {$description}</p>";
                echo "<form action='edit_project_form.php' method='post' style='display:inline;'>
                        <input type='hidden' name='id' value='{$id}'>
                        <input type='submit' value='Modifier' class='btn'>
                      </form>";
                echo "<form action='delete_project.php' method='post' style='display:inline;'>
                        <input type='hidden' name='id' value='{$id}'>
                        <input type='submit' value='Supprimer' class='btn'>
                      </form>";
                echo "<form action='p.php' method='post' style='display:inline;'>
                        <input type='hidden' name='project_id' value='{$id}'>
                        <input type='submit' value='Voir Tâches' class='btn'>
                      </form>";
                echo "<form action='view_project_report.php' method='post' style='display:inline;'>
                        <input type='hidden' name='project_id' value='{$id}'>
                        <input type='submit' value='Afficher Rapport' class='btn'>
                      </form>";
                echo "</div>";
            }
        } else {
            echo "<p>Aucun projet trouvé.</p>";
        }
        ?>

        <h2>Tâches</h2>
        <?php
        if ($taches->rowCount() > 0) {
            while ($row = $taches->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                echo "<div class='card'>";
                echo "<h2>{$nom}</h2>";
                echo "<p>Description : {$description}</p>";
                echo "<form action='edit_task_form2.php' method='post' style='display:inline;'>
                        <input type='hidden' name='id' value='{$id}'>
                        <input type='submit' value='Modifier' class='btn'>
                      </form>";
                echo "<form action='delete_task.php' method='post' style='display:inline;'>
                        <input type='hidden' name='id' value='{$id}'>
                        <input type='submit' value='Supprimer' class='btn'>
                      </form>";
                echo "<form action='view_task_report.php' method='post' style='display:inline;'>
                        <input type='hidden' name='task_id' value='{$id}'>
                        <input type='submit' value='Afficher Rapport' class='btn'>
                      </form>";
                echo "</div>";
            }
        } else {
            echo "<p>Aucune tâche trouvée.</p>";
        }
        ?>
    </div>

    <footer>
        <p>&copy; 2024 Gestion de Projet. Tous droits réservés.</p>
    </footer>
</body>
</html>
