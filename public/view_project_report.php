<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapports - Gestion de Projet</title>
    <link rel="stylesheet" href="../assets/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .chart-container {
            position: relative;
            width: 20%; /* Taille du graphe ajustée */
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
    </style>
    <script>
        function mettreAJourProjet(projetId) {
            fetch('update_project_status.php?projet_id=' + projetId)
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        alert('Statut et pourcentage mis à jour avec succès.');
                        location.reload(); // Recharger la page pour refléter les changements
                    } else {
                        alert('Erreur lors de la mise à jour.');
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    alert('Erreur lors de la mise à jour.');
                });
        }
    </script>
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
        <h1>Rapports</h1>

        <?php
        include_once '../classes/Database.php';
        include_once '../classes/Projet.php';
        include_once '../classes/Tache.php';

        $database = new Database();
        $db = $database->getConnection();

        $projet = new Projet($db);
        $stmt_projets = $projet->lireTous();

        while ($projet_row = $stmt_projets->fetch(PDO::FETCH_ASSOC)) {
            echo "<div class='section'>";
            echo "<h2>{$projet_row['nom']}</h2>";

            $tache = new Tache($db);
            $tache->projet_id = $projet_row['id'];
            $stmt_taches = $tache->lireTachesParProjet();

            $total_taches = $stmt_taches->rowCount();
            $taches_terminees = 0;
            $taches_en_cours = 0;

            while ($tache_row = $stmt_taches->fetch(PDO::FETCH_ASSOC)) {
                if ($tache_row['statut'] == 'Terminé') {  // Correction ici
                    $taches_terminees++;
                } else {  // Tout statut autre que "Terminé" est considéré comme "En cours"
                    $taches_en_cours++;
                }
            }

            $pourcentage_terminees = $total_taches > 0 ? ($taches_terminees / $total_taches) * 100 : 0;

            // Le statut du projet est mis à jour automatiquement dans la base de données
            $statut_projet = $total_taches > 0 && $taches_terminees == $total_taches ? 'Terminé' : 'En cours';

            echo "<table>
                    <tr>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Date de début</th>
                        <th>Date de fin prévue</th>
                        <th>Statut</th>
                        <th>Pourcentage Terminée</th>
                    </tr>
                    <tr>
                        <td>{$projet_row['nom']}</td>
                        <td>{$projet_row['description']}</td>
                        <td>{$projet_row['date_debut']}</td>
                        <td>{$projet_row['date_fin_prevue']}</td>
                        <td>{$statut_projet}</td>
                        <td>" . round($pourcentage_terminees, 2) . "%</td>
                    </tr>
                  </table>";

            echo "<a href='project_tasks.php?projet_id={$projet_row['id']}' class='btn'>Voir Tâches</a>";
            //echo "<button class='btn update' onclick='mettreAJourProjet({$projet_row['id']})'>Mettre à jour</button>";

            echo "<div class='chart-container'>
                    <canvas id='chart_{$projet_row['id']}'></canvas>
                  </div>";
            echo "</div>";
        }
        ?>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            <?php
            $stmt_projets = $projet->lireTous();
            while ($projet_row = $stmt_projets->fetch(PDO::FETCH_ASSOC)) {
                $tache = new Tache($db);
                $tache->projet_id = $projet_row['id'];
                $stmt_taches = $tache->lireTachesParProjet();

                $total_taches = $stmt_taches->rowCount();
                $taches_terminees = 0;
                $taches_en_cours = 0;

                while ($tache_row = $stmt_taches->fetch(PDO::FETCH_ASSOC)) {
                    if ($tache_row['statut'] == 'Terminé') {  // Correction ici
                        $taches_terminees++;
                    } else {  // Tout statut autre que "Terminé" est considéré comme "En cours"
                        $taches_en_cours++;
                    }
                }

                echo "var ctx = document.getElementById('chart_{$projet_row['id']}').getContext('2d');
                      var chart = new Chart(ctx, {
                          type: 'doughnut',
                          data: {
                              labels: ['Terminé', 'En cours'],
                              datasets: [{
                                  data: [$taches_terminees, $taches_en_cours],
                                  backgroundColor: ['#4caf50', '#ffeb3b'],
                                  borderWidth: 1
                              }]
                          },
                          options: {
                              responsive: true,
                              maintainAspectRatio: false
                          }
                      });";
            }
            ?>
        });
    </script>


</body>
</html>
