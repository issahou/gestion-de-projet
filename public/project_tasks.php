<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/style.css">
    <title>Tâches du Projet</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            color: #333;
            margin: 0;
            padding: 0;
        }
        nav {
            background-color: #007BFF;
            color: #fff;
            padding: 1rem;
            text-align: center;
        }
        nav a {
            color: #fff;
            text-decoration: none;
            margin: 0 1rem;
            font-weight: bold;
        }
        .container {
            max-width: 1200px;
            margin: 3rem auto;
            padding: 2rem;
            background-color: #fff;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        h1 {
            color: #007BFF;
            font-size: 2.5rem;
            margin-bottom: 2rem;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1rem;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #007BFF;
            color: #fff;
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
        <h1>Tâches du Projet</h1>

        <?php
        include_once '../classes/Database.php';
        include_once '../classes/Tache.php';

        $database = new Database();
        $db = $database->getConnection();

        $projet_id = isset($_GET['projet_id']) ? $_GET['projet_id'] : die('ERROR: Project ID not found.');

        $tache = new Tache($db);
        $tache->projet_id = $projet_id;
        $stmt = $tache->lireTachesParProjet();

        if ($stmt->rowCount() > 0) {
            echo "<table>
                    <tr>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Date de début</th>
                        <th>Date de fin prévue</th>
                        <th>Date de fin réelle</th>
                        <th>Statut</th>
                    </tr>";
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
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
