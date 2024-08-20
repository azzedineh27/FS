<?php
require_once 'Utils/functions.php'; 
require_once "Model/Model_car.php";
require_once "Model/Utilisateur.php"; 
require_once 'Utils/credentials.php';

if (session_id() === '') {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $bd = new PDO('mysql:host=localhost;dbname=voiture', 'root', 'Ultime10');
        $bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (Exception $e) {
        die('Error : ' . $e->getMessage());
    }

    $utilisateurModel = new Utilisateur($bd);

    $userId = $_SESSION['user_id'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $pays = $_POST['pays'];
    $telephone = $_POST['telephone'];
    $nomUtilisateur = $_POST['nom_utilisateur'];
    

    $success = $utilisateurModel->modifierUtilisateur($userId, $nomUtilisateur, $nom, $prenom, $pays, $telephone);

    if ($success) {
        header('Location: index.php?controller=connexion&action=ESPACE');
        exit;
    } else {
        echo 'Erreur lors de la mise à jour des informations personnelles.';
    }
}
?>
