// classes/Commentaire.php
<?php
class Commentaire {
    private $conn;
    private $table_name = "commentaires";

    public $id;
    public $tache_id;
    public $contenu;
    public $date_commentaire;
    public $auteur_id;
    public $parent_id;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Méthode pour lire les commentaires par tâche
    public function lireCommentairesParTache() {
        $query = "SELECT c.id, c.contenu, c.date_commentaire, c.auteur_id, u.nom AS auteur
                  FROM " . $this->table_name . " c
                  JOIN utilisateurs u ON c.auteur_id = u.id
                  WHERE c.tache_id = ?
                  ORDER BY c.date_commentaire DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->tache_id);
        $stmt->execute();
        return $stmt;
    }

    // Méthode pour lire un commentaire spécifique
    public function lireUn() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->tache_id = $row['tache_id'];
        $this->contenu = $row['contenu'];
        $this->date_commentaire = $row['date_commentaire'];
        $this->auteur_id = $row['auteur_id'];
        $this->parent_id = $row['parent_id'];
    }

    // Méthode pour ajouter un commentaire ou une réponse
    public function ajouter() {
        $query = "INSERT INTO " . $this->table_name . " SET tache_id = :tache_id, contenu = :contenu, date_commentaire = :date_commentaire, auteur_id = :auteur_id, parent_id = :parent_id";
        
        $stmt = $this->conn->prepare($query);

        // Liaison des paramètres
        $stmt->bindParam(':tache_id', $this->tache_id);
        $stmt->bindParam(':contenu', $this->contenu);
        $stmt->bindParam(':date_commentaire', $this->date_commentaire);
        $stmt->bindParam(':auteur_id', $this->auteur_id);
        $stmt->bindParam(':parent_id', $this->parent_id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Méthode pour supprimer un commentaire
    public function supprimer() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
