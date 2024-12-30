<?php

class Utilisateur {
    private $conn;
    private $table_name = "utilisateurs";

    public $id;
    public $nom;
    public $email;
    public $mot_de_passe;
    public $role;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getTableName() {
        return $this->table_name;
    }

    public function getRoles() {
        $query = "SELECT DISTINCT role FROM roles"; // Assurez-vous que votre table des rôles s'appelle 'roles'
        $stmt = $this->conn->prepare($query); // Initialiser correctement $stmt
        $stmt->execute(); // Exécuter la requête
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Récupérer tous les rôles
    }

    public function creer() {
        $query = "INSERT INTO " . $this->table_name . " (nom, email, mot_de_passe, role) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        $this->nom = htmlspecialchars(strip_tags($this->nom));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->mot_de_passe = password_hash($this->mot_de_passe, PASSWORD_BCRYPT);
        $this->role = htmlspecialchars(strip_tags($this->role));

        $stmt->bindParam(1, $this->nom);
        $stmt->bindParam(2, $this->email);
        $stmt->bindParam(3, $this->mot_de_passe);
        $stmt->bindParam(4, $this->role);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function lireTous() {
        $query = "SELECT * FROM " . $this->table_name;
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

    public function mettreAJour() {
        $query = "UPDATE " . $this->table_name . "
                  SET nom = :nom,
                      email = :email,
                      mot_de_passe = :mot_de_passe,
                      role = :role
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $this->nom = htmlspecialchars(strip_tags($this->nom));
        $this->email = htmlspecialchars(strip_tags($this->email));
        if (!empty($this->mot_de_passe)) {
            $this->mot_de_passe = password_hash($this->mot_de_passe, PASSWORD_BCRYPT);
        } else {
            // Récupérer le mot de passe existant s'il n'est pas modifié
            $existingUser = $this->lireUn()->fetch(PDO::FETCH_ASSOC);
            $this->mot_de_passe = $existingUser['mot_de_passe'];
        }
        $this->role = htmlspecialchars(strip_tags($this->role));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':nom', $this->nom);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':mot_de_passe', $this->mot_de_passe);
        $stmt->bindParam(':role', $this->role);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function supprimer() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(1, $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function estChefDeProjet($tache_id) {
        $query = "SELECT COUNT(*) as count FROM projets WHERE id = (SELECT projet_id FROM taches WHERE id = ?) AND chef_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $tache_id);
        $stmt->bindParam(2, $this->id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row['count'] > 0;
    }

    public function estAdministrateur() {
        return $this->role == 'Administrateur'; // Assurez-vous que la comparaison est correcte
    }

    public function connexion($mot_de_passe) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->email);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row && password_verify($mot_de_passe, $row['mot_de_passe'])) {
            $this->id = $row['id'];
            $this->nom = $row['nom'];
            $this->email = $row['email'];
            $this->role = $row['role'];
            return true;
        }

        return false;
    }

    public function verifierIdentifiants($email, $password) {
        $query = "SELECT id, email, mot_de_passe FROM " . $this->table_name . " WHERE email = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $row['mot_de_passe'])) {
                $this->id = $row['id'];
                $this->email = $row['email'];
                return true;
            }
        }
        return false;
    }

}
?>
