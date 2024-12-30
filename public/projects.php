<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/style.css">
    <title>Projets</title>
    <script>
        function confirmerSuppression(projetId) {
            if (confirm("Êtes-vous sûr de vouloir supprimer ce projet ?")) {
                document.getElementById('form-supprimer-' + projetId).submit();
            }
        }
    </script>
    <style>
        .floating-btn {
            position: fixed;
            top: 80px;
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
            Liste des Projets
            <button class="floating-btn" onclick="window.location.href='add_project_form.php'">Ajouter</button>
        </h1>
        <?php
        include_once '../classes/Database.php';
        include_once '../classes/Projet.php';

        $database = new Database();
        $db = $database->getConnection();

        $projet = new Projet($db);
        $stmt = $projet->lireTous();
        $num = $stmt->rowCount();

        if ($num > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                echo "<div class='card'>";
                echo "<h2>{$nom}</h2>";
                echo "<p>Description : {$description}</p>";
                echo "<p>Date de début : {$date_debut}</p>";
                echo "<p>Date de fin prévue : {$date_fin_prevue}</p>";
                echo "<p>Statut : {$statut}</p>";
                echo "<a href='edit_project_form.php?id={$id}' class='btn'>Modifier</a> ";
                echo "<form id='form-supprimer-{$id}' action='delete_project.php' method='post' style='display:inline;'>
                          <input type='hidden' name='id' value='{$id}'>
                          <a href='#' onclick='confirmerSuppression({$id}); return false;' class='btn'>Supprimer</a>
                      </form>";
                echo "</div>";
            }
        } else {
            echo "<p>Aucun projet trouvé.</p>";
        }
        ?>
        

</body>
</html>
