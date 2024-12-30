<?php
session_start();

include_once '../classes/Database.php';
include_once '../classes/Tache.php';

$database = new Database();
$db = $database->getConnection();

$tache = new Tache($db);
$projet_id = isset($_POST['project_id']) ? $_POST['project_id'] : die('ERROR: Project ID not found.');
$taches = $tache->lireParProjet($projet_id);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/style.css">
    <title>Tâches du Projet</title>
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
        <h1>Tâches du Projet</h1>

        <?php
        if ($taches->rowCount() > 0) {
            echo "<table>
                    <tr>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Date de début</th>
                        <th>Date de fin prévue</th>
                        <th>Date de fin réelle</th>
                        <th>Statut</th>
                    </tr>";
            while ($row = $taches->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>
                        <td>{$row['nom']}</td>
                        <td>{$row['description']}</td>
                        <td>{$row['date_debut']}</td>
                        <td>{$row['date_fin_prevue']}</td>
                        <td>{$row['date_fin_reelle']}</td>
                        <td>{$row['statut']}</td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "<p>Aucune tâche trouvée pour ce projet.</p>";
        }
        ?>
        <a href="reports.php" class="btn">Retour aux Rapports</a>
    </div>

    <footer>
        <p>&copy; 2024 Gestion de Projet. Tous droits réservés.</p>
    </footer>
</body>
</html>
