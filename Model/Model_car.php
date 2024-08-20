<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class Model {
    private $bd;
    
    private static $instance = null;
    private function __construct() {
        include "Utils/credentials.php";
        $this->bd = new PDO($dsn, $login, $mdp);
        $this->bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->bd->query("SET NAMES 'utf8'");
    }

    public static function getModel() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function getVoitures($limit = 10, $offset = 0) {
        $req = $this->bd->prepare("SELECT * FROM voitures LIMIT :limit OFFSET :offset");
        $req->bindParam(':limit', $limit, PDO::PARAM_INT);
        $req->bindParam(':offset', $offset, PDO::PARAM_INT);
        $req->execute();
        return $req->fetchAll();
    }
    
    public function countVoitures() {
        $req = $this->bd->query("SELECT COUNT(*) FROM voitures");
        return $req->fetchColumn();
    }

    public function getVoiture($nomVoiture) {
        $req = $this->bd->prepare("SELECT * FROM voitures WHERE modele = :modele");
        $req->bindParam(':modele', $nomVoiture);
        $req->execute();
        return $req->fetch();   
    }
    public function rechercher($marque, $modele, $energie, $anneeMin, $anneeMax, $prixMin, $prixMax, $kmMin, $kmMax) {
        $conditions = [];
        $params = [];
        
        if (!empty($marque)) {
            $conditions[] = "marque LIKE :marque";
            $params[':marque'] = "%$marque%";
        }
        if (!empty($modele)) {
            $conditions[] = "modele LIKE :modele";
            $params[':modele'] = "%$modele%";
        }
        if (!empty($energie)) {
            $conditions[] = "energie LIKE :energie";
            $params[':energie'] = "%$energie%";
        }
        if (!empty($anneeMin)) {
            $conditions[] = "annee >= :anneeMin";
            $params[':anneeMin'] = $anneeMin;
        }
        if (!empty($anneeMax)) {
            $conditions[] = "annee <= :anneeMax";
            $params[':anneeMax'] = $anneeMax;
        }
        if (!empty($prixMin)) {
            $conditions[] = "prix >= :prixMin";
            $params[':prixMin'] = $prixMin;
        }
        if (!empty($prixMax)) {
            $conditions[] = "prix <= :prixMax";
            $params[':prixMax'] = $prixMax;
        }
        if (!empty($kmMin)) {
            $conditions[] = "kilometrage >= :kmMin";
            $params[':kmMin'] = $kmMin;
        }
        if (!empty($kmMax)) {
            $conditions[] = "kilometrage <= :kmMax";
            $params[':kmMax'] = $kmMax;
        }
    
        $query = "SELECT * FROM voitures";
        if ($conditions) {
            $query .= " WHERE " . implode(" AND ", $conditions);
        }
    
        $req = $this->bd->prepare($query);
        foreach ($params as $key => &$val) {
            $req->bindParam($key, $val);
        }
        $req->execute();
        return $req->fetchAll();
    }

    public function countRechercher($marque, $modele, $energie, $anneeMin, $anneeMax, $prixMin, $prixMax) {
        $conditions = [];
        $params = [];
        
        if (!empty($marque)) {
            $conditions[] = "marque LIKE :marque";
            $params[':marque'] = "%$marque%";
        }
        if (!empty($modele)) {
            $conditions[] = "modele LIKE :modele";
            $params[':modele'] = "%$modele%";
        }
        if (!empty($energie)) {
            $conditions[] = "energie LIKE :energie";
            $params[':energie'] = "%$energie%";
        }
        if (!empty($anneeMin)) {
            $conditions[] = "annee >= :anneeMin";
            $params[':anneeMin'] = $anneeMin;
        }
        if (!empty($anneeMax)) {
            $conditions[] = "annee <= :anneeMax";
            $params[':anneeMax'] = $anneeMax;
        }
        if (!empty($prixMin)) {
            $conditions[] = "prix >= :prixMin";
            $params[':prixMin'] = $prixMin;
        }
        if (!empty($prixMax)) {
            $conditions[] = "prix <= :prixMax";
            $params[':prixMax'] = $prixMax;
        }
    
        if (!empty($kmMin)) {
            $conditions[] = "kilometrage >= :kmMin";
            $params[':kmMin'] = $kmMin;
        }
        if (!empty($kmMax)) {
            $conditions[] = "kilometrage <= :kmMax";
            $params[':kmMax'] = $kmMax;
        }
        
        $query = "SELECT COUNT(*) FROM voitures";
        if ($conditions) {
            $query .= " WHERE " . implode(" AND ", $conditions);
        }
    
        $req = $this->bd->prepare($query);
        foreach ($params as $key => &$val) {
            $req->bindParam($key, $val);
        }
        $req->execute();
        return $req->fetchColumn();
    }
    
    public function ajouterFavori($utilisateurId, $voitureId) {
        // Vérifier si la voiture est déjà en favoris
        $check = $this->bd->prepare("SELECT * FROM favoris WHERE utilisateur_id = :utilisateur_id AND voiture_id = :voiture_id");
        $check->bindParam(':utilisateur_id', $utilisateurId);
        $check->bindParam(':voiture_id', $voitureId);
        $check->execute();
        if ($check->fetch()) {
            // La voiture est déjà dans les favoris
            return 'deja_en_favoris'; // Ou lancez une exception personnalisée
        }
    
        // Si non, ajoutez la voiture aux favoris
        $req = $this->bd->prepare("INSERT INTO favoris (utilisateur_id, voiture_id) VALUES (:utilisateur_id, :voiture_id)");
        $req->bindParam(':utilisateur_id', $utilisateurId);
        $req->bindParam(':voiture_id', $voitureId);
        if ($req->execute()) {
            return 'ajout_succes';
        } else {
            return 'erreur_ajout';
        }
    }
    public function estEnFavoris($utilisateurId, $voitureId) {
        $query = $this->bd->prepare("SELECT COUNT(*) FROM favoris WHERE utilisateur_id = :utilisateur_id AND voiture_id = :voiture_id");
        $query->execute(['utilisateur_id' => $utilisateurId, 'voiture_id' => $voitureId]);
        $count = $query->fetchColumn();
        return $count > 0;
    }
    

    public function supprimerFavori($utilisateurId, $voitureId) {
        $req = $this->bd->prepare("DELETE FROM favoris WHERE utilisateur_id = :utilisateur_id AND voiture_id = :voiture_id");
        $req->bindParam(':utilisateur_id', $utilisateurId);
        $req->bindParam(':voiture_id', $voitureId);
        return $req->execute();
    }

    public function getFavorisUtilisateur($utilisateurId) {
        $req = $this->bd->prepare("SELECT v.* FROM voitures v JOIN favoris f ON v.id = f.voiture_id WHERE f.utilisateur_id = :utilisateur_id");
        $req->bindParam(':utilisateur_id', $utilisateurId);
        $req->execute();
        return $req->fetchAll();
    }

    
}

