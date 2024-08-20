<?php
session_start();
require_once "Model/Model_car.php";

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Vous devez être connecté pour ajouter aux favoris.']);
    exit;
}

$utilisateurId = $_SESSION['user_id'];
$voitureId = $_POST['voiture_id'] ?? '';

$model = Model::getModel();
$resultat = $model->ajouterFavori($utilisateurId, $voitureId);

if ($resultat === 'deja_en_favoris') {
    echo json_encode(['success' => false, 'message' => 'Voiture déjà en favoris.']);
} elseif ($resultat === 'ajout_succes') {
    echo json_encode(['success' => true, 'message' => 'Voiture ajoutée aux favoris avec succès!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'ajout aux favoris.']);
}

