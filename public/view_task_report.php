<?php
include_once '../classes/Database.php';
include_once '../classes/Tache.php';

$database = new Database();
$db = $database->getConnection();

$task_id = isset($_POST['task_id']) ? $_POST['task_id'] : die('ERROR: Task ID not found.');

$tache = new Tache($db);
$tache->id = $task_id;
$tache->lireUn();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapport de la Tâche</title>
    <link rel="stylesheet" href="../assets/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .chart-container {
            position: relative;
            width: 50%; /* Taille du graphe ajustée */
            margin: 0 auto; /* Centrer le graphe */
        }

        .btn {
            display: inline-block; /* Modifier pour inline-block */
            margin: 10px 0; /* Ajuster la marge */
            padding: 5px 10px; /* Réduire la taille du bouton */
            background-color: #007bff; /* Couleur bleue */
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
        }

        .btn.update {
            margin-left: 10px; /* Espacement entre les boutons */
            background-color: #28a745; /* Couleur verte pour le bouton Mettre à jour */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        th {
            background-color: blue;
            text-align: left;
        }

        tr:hover {
            background-color: #f1f1f1;
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
        <h1>Rapport de la Tâche</h1>

        <table>
            <tr>
                <th>Nom</th>
                <th>Description</th>
                <th>Date de début</th>
                <th>Date de fin prévue</th>
                <th>Date de fin réelle</th>
                <th>Statut</th>
                <th>Priorité</th>
                <th>Affectataire</th>
            </tr>
            <tr>
                <td><?php echo htmlspecialchars($tache->nom ?? ''); ?></td>
                <td><?php echo htmlspecialchars($tache->description ?? ''); ?></td>
                <td><?php echo htmlspecialchars($tache->date_debut ?? ''); ?></td>
                <td><?php echo htmlspecialchars($tache->date_fin_prevue ?? ''); ?></td>
                <td><?php echo htmlspecialchars($tache->date_fin_reelle ?? ''); ?></td>
                <td><?php echo htmlspecialchars($tache->statut ?? ''); ?></td>
                <td><?php echo htmlspecialchars($tache->priorite ?? ''); ?></td>
                <td><?php echo htmlspecialchars($tache->affectataire_id ?? ''); ?></td>
            </tr>
        </table>

        <a href="tasks.php" class="btn">Retour aux Tâches</a>
    </div>

    <footer>
        <p>&copy; 2024 Gestion de Projet. Tous droits réservés.</p>
    </footer>
</body>
</html>
