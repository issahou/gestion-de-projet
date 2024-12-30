<?php
class Administrateur extends Utilisateur {

    public function __construct($db) {
        parent::__construct($db);
        $this->role = 'admin';
    }

    public function creerUtilisateur($nom, $email, $mot_de_passe, $role) {
        $utilisateur = new Utilisateur($this->conn);
        $utilisateur->nom = $nom;
        $utilisateur->email = $email;
        $utilisateur->mot_de_passe = $mot_de_passe;
        $utilisateur->role = $role;
        return $utilisateur->creer();
    }

    public function supprimerUtilisateur($id) {
        $utilisateur = new Utilisateur($this->conn);
        $utilisateur->id = $id;
        return $utilisateur->supprimer();
    }
}
?>
