<?php 
require_once "Utils/credentials.php";
require_once "Model/Model_car.php";
class Utilisateur {
    private $bd;

    public function __construct($bd) {
        $this->bd = $bd;
    }
    public function getUserById($userId) {
        $stmt = $this->bd->prepare("SELECT * FROM utilisateurs WHERE id = :id");
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result : null;
    }
    public function getUsernameById($userId) {
        $stmt = $this->bd->prepare("SELECT nom_utilisateur FROM utilisateurs WHERE id = :id");
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        $stmt->execute();

        // Récupérez le résultat
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Si un utilisateur est trouvé, renvoyez le nom d'utilisateur
        if($result) {
            return $result['nom_utilisateur'];
        } else {
            return null; // Aucun utilisateur trouvé avec cet ID
        }
    }

    public function verifierIdentifiants($nomUtilisateur, $motDePasse) {
        $req = $this->bd->prepare("SELECT id, mot_de_passe FROM utilisateurs WHERE nom_utilisateur = :nom_utilisateur");
        $req->bindParam(':nom_utilisateur', $nomUtilisateur);
        $req->execute();
        $utilisateur = $req->fetch();
    
        if ($utilisateur && password_verify($motDePasse, $utilisateur['mot_de_passe'])) {
            return $utilisateur['id']; 
        }
        return false;
    }

    public function ajouterUtilisateur($nomUtilisateur, $motDePasse, $nom, $prenom, $pays, $telephone) {
    $req = $this->bd->prepare("INSERT INTO utilisateurs (nom_utilisateur, mot_de_passe, nom, prenom, pays, telephone) VALUES (:nom_utilisateur, :mot_de_passe, :nom, :prenom, :pays, :telephone)");
    $req->bindParam(':nom_utilisateur', $nomUtilisateur);
    $req->bindParam(':mot_de_passe', $motDePasse);
    $req->bindParam(':nom', $nom);
    $req->bindParam(':prenom', $prenom);
    $req->bindParam(':pays', $pays);
    $req->bindParam(':telephone', $telephone);
    return $req->execute();
}
    
    

    public function verifierPersonne($nom, $nomD) {
        // Préparation de la requête SQL pour vérifier si le nom et le nom d'utilisateur correspondent
        $requete = $this->bd->prepare("SELECT * FROM utilisateurs WHERE nom = :nom AND nom_utilisateur = :nomD");
        // Liaison des paramètres
        $requete->bindParam(':nom', $nom);
        $requete->bindParam(':nomD', $nomD);
        // Exécution de la requête
        $requete->execute();
        // Récupération du résultat
        $resultat = $requete->fetch(PDO::FETCH_ASSOC);
        // Retourner le résultat
        return $resultat;
    }

    public function changerMotDePasse($nom, $nomUtilisateur, $nouveauMotDePasse) {
        // Hachage du nouveau mot de passe
        $motDePasseHache = password_hash($nouveauMotDePasse, PASSWORD_DEFAULT);

        // Préparation de la requête SQL pour mettre à jour le mot de passe
        $requete = $this->bd->prepare("UPDATE utilisateurs SET mot_de_passe = :nouveauMotDePasse WHERE nom = :nom AND nom_utilisateur = :nom_utilisateur");

        // Liaison des paramètres
        $requete->bindParam(':nouveauMotDePasse', $motDePasseHache);
        $requete->bindParam(':nom', $nom);
        $requete->bindParam(':nom_utilisateur', $nomUtilisateur);

        // Exécution de la requête
        $resultat = $requete->execute();

        // Vérification du succès de la mise à jour
        if ($resultat) {
            // Mise à jour réussie
            return true;
        } else {
            // Erreur lors de la mise à jour
            return false;
        }
    }
    public function modifierUtilisateur($userId, $nomUtilisateur, $nom, $prenom, $pays, $telephone) {
        $req = $this->bd->prepare("UPDATE utilisateurs SET nom_utilisateur = :nom_utilisateur, nom = :nom, prenom = :prenom, pays = :pays, telephone = :telephone WHERE id = :id");
        $req->bindParam(':nom_utilisateur', $nomUtilisateur);
        $req->bindParam(':nom', $nom);
        $req->bindParam(':prenom', $prenom);
        $req->bindParam(':pays', $pays);
        $req->bindParam(':telephone', $telephone);
        $req->bindParam(':id', $userId, PDO::PARAM_INT);
        return $req->execute();
    }
 
}


