<?php

include_once "Controllers/Controller.php";

class Controller_first extends Controller
{
    public function action_afficher_toutes_voitures() {
        $m = Model::getModel();
        $limit = 10;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;
        
        $voitures = $m->getVoitures($limit, $offset);
        $totalVoitures = $m->countVoitures();
        $totalPages = ceil($totalVoitures / $limit);
        
        $data = [
            "voitures" => $voitures,
            "currentPage" => $page,
            "totalPages" => $totalPages,
        ];
    
        $this->render("afficher_toutes_voitures", $data);
    }
    
    
    public function action_rechercher_voitures() {
        $m = Model::getModel();
    
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Initialiser les critères de recherche
            $marque = $_POST['marque'] ?? '';
            $modele = $_POST['modele'] ?? '';
            $energie = $_POST['energie'] ?? '';
            $anneeMin = $_POST['anneeMin'] ?? 0;
            $anneeMax = $_POST['anneeMax'] ?? date("Y");  // Année actuelle comme valeur par défaut
            $prixMin = $_POST['prixMin'] ?? 0;
            $prixMax = $_POST['prixMax'] ?? PHP_INT_MAX;  // Valeur maximale pour un integer
            $kmMin = $_POST['kmMin'] ?? 0;
            $kmMax = $_POST['kmMax'] ?? PHP_INT_MAX; // Valeur maximale pour un integer
    
            // Enregistrer les critères de recherche dans la session
            $_SESSION['search'] = compact('marque', 'modele', 'energie', 'anneeMin', 'anneeMax', 'prixMin', 'prixMax', 'kmMin', 'kmMax');
    
            // Effectuer la recherche
            $voitures = $m->rechercher($marque, $modele, $energie, $anneeMin, $anneeMax, $prixMin, $prixMax, $kmMin, $kmMax);
        } else {
            // Récupérer les critères de recherche de la session
            $criteria = $_SESSION['search'] ?? [];
            $marque = $criteria['marque'] ?? '';
            $modele = $criteria['modele'] ?? '';
            $energie = $criteria['energie'] ?? '';
            $anneeMin = $criteria['anneeMin'] ?? 0;
            $anneeMax = $criteria['anneeMax'] ?? date("Y");
            $prixMin = $criteria['prixMin'] ?? 0;
            $prixMax = $criteria['prixMax'] ?? PHP_INT_MAX;
            $kmMin = $criteria['kmMin'] ?? 0;
            $kmMax = $criteria['kmMax'] ?? PHP_INT_MAX;
    
            // Effectuer la recherche
            $voitures = $m->rechercher($marque, $modele, $energie, $anneeMin, $anneeMax, $prixMin, $prixMax, $kmMin, $kmMax);
        }
    
        $limit = 10;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;
    
        $totalVoitures = count($voitures);
        $totalPages = ceil($totalVoitures / $limit);
        $voitures = array_slice($voitures, $offset, $limit);
    
        $data = [
            "voitures" => $voitures,
            "currentPage" => $page,
            "totalPages" => $totalPages,
        ];
    
        $this->render("rechercher_voitures", $data);
    }
    
 
    public function action_default()
    {
        $this->action_afficher_toutes_voitures();
    }
}

