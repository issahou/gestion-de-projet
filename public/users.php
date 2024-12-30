<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/style.css">
    <title>Utilisateurs</title>
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
            Liste des Utilisateurs
            <button class="floating-btn" onclick="window.location.href='add_user_form.php'">Ajouter</button>
        </h1>
        <?php
        include_once '../classes/Database.php';
        include_once '../classes/Utilisateur.php';

        $database = new Database();
        $db = $database->getConnection();

        $utilisateur = new Utilisateur($db);
        $stmt = $utilisateur->lireTous();
        $num = $stmt->rowCount();

        if ($num > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                echo "<div class='card'>";
                echo "<h2>{$nom}</h2>";
                echo "<p>Email : {$email}</p>";
                echo "<p>Rôle : {$role}</p>";
                echo "<a href='edit_user_form.php?id={$id}' class='btn'>Modifier</a> ";
                echo "<form action='delete_user.php' method='post' style='display:inline;'>
                          <input type='hidden' name='id' value='{$id}'>
                          <input type='submit' value='Supprimer' class='btn'>
                      </form>";
                echo "</div>";
            }
        } else {
            echo "<p>Aucun utilisateur trouvé.</p>";
        }
        ?>
    </div>

    >
</body>
</html>
