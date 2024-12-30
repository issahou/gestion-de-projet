<?php
class Projet {
    private $conn;
    private $table_name = "projets";

    public $id;
    public $nom;
    public $description;
    public $date_debut;
    public $date_fin_prevue;
    public $statut;
    public $responsable_id;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function lireTous() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY date_debut DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function lireUn() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        return $stmt;
    }

    public function creer() {
        $query = "INSERT INTO " . $this->table_name . " (nom, description, date_debut, date_fin_prevue, statut, responsable_id) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        $this->nom = htmlspecialchars(strip_tags($this->nom));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->date_debut = htmlspecialchars(strip_tags($this->date_debut));
        $this->date_fin_prevue = htmlspecialchars(strip_tags($this->date_fin_prevue));
        $this->statut = htmlspecialchars(strip_tags($this->statut));
        $this->responsable_id = htmlspecialchars(strip_tags($this->responsable_id));

        $stmt->bindParam(1, $this->nom);
        $stmt->bindParam(2, $this->description);
        $stmt->bindParam(3, $this->date_debut);
        $stmt->bindParam(4, $this->date_fin_prevue);
        $stmt->bindParam(5, $this->statut);
        $stmt->bindParam(6, $this->responsable_id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function modifier() {
        $query = "UPDATE " . $this->table_name . "
                  SET nom = :nom,
                      description = :description,
                      date_debut = :date_debut,
                      date_fin_prevue = :date_fin_prevue,
                      statut = :statut,
                      responsable_id = :responsable_id
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $this->nom = htmlspecialchars(strip_tags($this->nom));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->date_debut = htmlspecialchars(strip_tags($this->date_debut));
        $this->date_fin_prevue = htmlspecialchars(strip_tags($this->date_fin_prevue));
        $this->statut = htmlspecialchars(strip_tags($this->statut));
        $this->responsable_id = htmlspecialchars(strip_tags($this->responsable_id));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':nom', $this->nom);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':date_debut', $this->date_debut);
        $stmt->bindParam(':date_fin_prevue', $this->date_fin_prevue);
        $stmt->bindParam(':statut', $this->statut);
        $stmt->bindParam(':responsable_id', $this->responsable_id);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function supprimer() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function modifierStatut() {
        $query = "UPDATE " . $this->table_name . " SET statut = :statut WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $this->statut = htmlspecialchars(strip_tags($this->statut));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':statut', $this->statut);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
	
	
public function modifierStatut2() {
    $query = "UPDATE " . $this->table_name . " SET statut = :statut WHERE id = :id";

    $stmt = $this->conn->prepare($query);

    $this->statut = htmlspecialchars(strip_tags($this->statut));
    $this->id = htmlspecialchars(strip_tags($this->id));

    $stmt->bindParam(':statut', $this->statut);
    $stmt->bindParam(':id', $this->id);

    if ($stmt->execute()) {
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
 return $stmt; }

}
?>
