// classes/Tache.php
<?php
class Tache {
    private $conn;
    private $table_name = "taches";

    public $id;
    public $nom;
    public $description;
    public $date_debut;
    public $date_fin_prevue;
    public $date_fin_reelle;
    public $statut;
    public $priorite;
    public $affectataire_id;
    public $projet_id;  // Ajout de la propriété projet_id

    public function __construct($db) {
        $this->conn = $db;
    }

    // Méthode pour lire toutes les tâches
    public function lireTous() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY date_debut DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Méthode pour lire une tâche spécifique
    public function lireUn() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->nom = $row['nom'];
        $this->description = $row['description'];
        $this->date_debut = $row['date_debut'];
        $this->date_fin_prevue = $row['date_fin_prevue'];
        $this->date_fin_reelle = $row['date_fin_reelle'];
        $this->statut = $row['statut'];
        $this->priorite = $row['priorite'];
        $this->affectataire_id = $row['affectataire_id'];
        $this->projet_id = $row['projet_id'];
    }

    // Méthode pour ajouter une tâche
    public function ajouter() {
        $query = "INSERT INTO " . $this->table_name . "
                  SET nom = :nom, description = :description, date_debut = :date_debut, date_fin_prevue = :date_fin_prevue, 
                      date_fin_reelle = :date_fin_reelle, statut = :statut, priorite = :priorite, affectataire_id = :affectataire_id, projet_id = :projet_id";
        
        $stmt = $this->conn->prepare($query);

        // Liaison des paramètres
        $stmt->bindParam(':nom', $this->nom);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':date_debut', $this->date_debut);
        $stmt->bindParam(':date_fin_prevue', $this->date_fin_prevue);
        $stmt->bindParam(':date_fin_reelle', $this->date_fin_reelle);
        $stmt->bindParam(':statut', $this->statut);
        $stmt->bindParam(':priorite', $this->priorite);
        $stmt->bindParam(':affectataire_id', $this->affectataire_id);
        $stmt->bindParam(':projet_id', $this->projet_id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Méthode pour modifier une tâche
    public function modifier() {
        $query = "UPDATE " . $this->table_name . "
                  SET nom = :nom, description = :description, date_debut = :date_debut, date_fin_prevue = :date_fin_prevue, 
                      date_fin_reelle = :date_fin_reelle, statut = :statut, priorite = :priorite, affectataire_id = :affectataire_id, projet_id = :projet_id
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);

        // Liaison des paramètres
        $stmt->bindParam(':nom', $this->nom);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':date_debut', $this->date_debut);
        $stmt->bindParam(':date_fin_prevue', $this->date_fin_prevue);
        $stmt->bindParam(':date_fin_reelle', $this->date_fin_reelle);
        $stmt->bindParam(':statut', $this->statut);
        $stmt->bindParam(':priorite', $this->priorite);
        $stmt->bindParam(':affectataire_id', $this->affectataire_id);
        $stmt->bindParam(':projet_id', $this->projet_id);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Méthode pour supprimer une tâche
    public function supprimer() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // classes/Tache.php
public function modifierStatut() {
    $query = "UPDATE " . $this->table_name . "
              SET statut = :statut,
                  date_fin_reelle = :date_fin_reelle
              WHERE id = :id";

    $stmt = $this->conn->prepare($query);

    $this->statut = htmlspecialchars(strip_tags($this->statut));
    $this->date_fin_reelle = date('Y-m-d H:i:s');
    $this->id = htmlspecialchars(strip_tags($this->id));

    $stmt->bindParam(':statut', $this->statut);
    $stmt->bindParam(':date_fin_reelle', $this->date_fin_reelle);
    $stmt->bindParam(':id', $this->id);

    if ($stmt->execute()) {
        return true;
    }

    return false;
}

    public function lireTachesParProjet() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE projet_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->projet_id);
        $stmt->execute();
        return $stmt;
    }

   public function mettreAJourStatutProjet() {
    $query = "SELECT COUNT(*) as total, SUM(CASE WHEN statut = 'terminée' THEN 1 ELSE 0 END) as terminees 
              FROM " . $this->table_name . " WHERE projet_id = :projet_id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':projet_id', $this->projet_id);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $statut_projet = ($row['total'] == $row['terminees']) ? 'Terminé' : 'En cours';

    $query = "UPDATE projets SET statut = :statut WHERE id = :projet_id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':statut', $statut_projet);
    $stmt->bindParam(':projet_id', $this->projet_id);
    $stmt->execute();
}


public function modifier2() {
    $query = "UPDATE " . $this->table_name . "
              SET nom = :nom,
                  description = :description,
                  date_debut = :date_debut,
                  date_fin_prevue = :date_fin_prevue,
                  date_fin_reelle = :date_fin_reelle,
                  statut = :statut,
                  priorite = :priorite,
                  affectataire_id = :affectataire_id,
                  projet_id = :projet_id
              WHERE id = :id";

    $stmt = $this->conn->prepare($query);

    // Liaison des paramètres
    $stmt->bindParam(':nom', $this->nom);
    $stmt->bindParam(':description', $this->description);
    $stmt->bindParam(':date_debut', $this->date_debut);
    $stmt->bindParam(':date_fin_prevue', $this->date_fin_prevue);
    $stmt->bindParam(':date_fin_reelle', $this->date_fin_reelle);
    $stmt->bindParam(':statut', $this->statut);
    $stmt->bindParam(':priorite', $this->priorite);
    $stmt->bindParam(':affectataire_id', $this->affectataire_id);
    $stmt->bindParam(':projet_id', $this->projet_id);
    $stmt->bindParam(':id', $this->id);

    if ($stmt->execute()) {
        $this->mettreAJourStatutProjet();
        return true;
    }

    return false;
}
public function rechercher($query) { 
$query = "%" . $query . "%";
 $sql = "SELECT * FROM " . $this->table_name . " WHERE nom LIKE ? OR description LIKE ?";
 $stmt = $this->conn->prepare($sql);
 $stmt->bindParam(1, $query);
 $stmt->bindParam(2, $query);
 $stmt->execute();
 return $stmt; 
 }
 
 public function lireParProjet($projet_id) { 
 $query = "SELECT * FROM " . $this->table_name . " WHERE projet_id = ?";
 $stmt = $this->conn->prepare($query);
 $stmt->bindParam(1, $projet_id);
 $stmt->execute();
 return $stmt; }



}
?>


  





