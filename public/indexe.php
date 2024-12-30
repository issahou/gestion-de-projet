<?php session_start();
 if (!isset($_SESSION['utilisateur_id'])) { 
 header("Location: login.php");
 exit();
 } 
 ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Gestion de Projet</title>
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
            text-align: center;
        }
        h1 {
            color: #007BFF;
            font-size: 3rem;
            margin-bottom: 1rem; /* Ajustez cette valeur pour un espacement supplémentaire */
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }
        .section {
            padding: 2rem;
            background-color: #007BFF;
            color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .section h2 {
            margin-bottom: 1rem;
        }
        .section p {
            margin-bottom: 1.5rem;
        }
        .section a {
            display: inline-block;
            padding: 0.5rem 1rem;
            color: #fff;
            background-color: #0056b3;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .section a:hover {
            background-color: #003d80;
        }
        .search-container {
            margin-top: 2rem; /* Ajustez cette valeur pour un espacement supplémentaire */
            text-align: center;
        }
        .search-container input[type="text"] {
            padding: 0.5rem;
            width: 300px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .search-container input[type="submit"] {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 5px;
            background-color: #007BFF;
            color: #fff;
            cursor: pointer;
        }
        .search-container input[type="submit"]:hover {
            background-color: #0056b3;
        }
        footer {
            background-color: #007BFF;
            color: #fff;
            text-align: center;
            padding: 1rem;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
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
        <h1>Bienvenue</h1>
        <p>Gérez vos projets efficacement avec notre plateforme.</p>

        <div class="search-container">
    <form action="search.php" method="POST">
        <input type="text" name="query" placeholder="Rechercher des projets ou des tâches..." required>
        <input type="submit" value="Rechercher">
    </form>
</div>

        
		<div style="color:transparent">eeee</div>
		<div style="color:transparent">eeee</div>

        <div class="grid">
            <div class="section">
                <h2>Projets</h2>
                <p>Créez et gérez vos projets.</p>
                <a href="projects.php">Accéder</a>
            </div>

            <div class="section">
                <h2>Tâches</h2>
                <p>Suivez les tâches de vos projets.</p>
                <a href="tasks.php">Accéder</a>
            </div>

            <div class="section">
                <h2>Utilisateurs</h2>
                <p>Gérez les utilisateurs de votre équipe.</p>
                <a href="users.php">Accéder</a>
            </div>

            <div class="section">
                <h2>Rapports</h2>
                <p>Générez des rapports détaillés.</p>
                <a href="reports.php">Accéder</a>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 Gestion de Projet. Tous droits réservés.</p>
    </footer>
</body>
</html>
