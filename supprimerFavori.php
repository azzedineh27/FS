<?php
if (session_id() === '') {
    session_start();
}
require_once "Model/Model_car.php";

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Vous devez être connecté pour modifier les favoris.']);
    exit;
}

$utilisateurId = $_SESSION['user_id'];
$voitureId = $_POST['voiture_id'] ?? '';

$model = Model::getModel();
$resultat = $model->supprimerFavori($utilisateurId, $voitureId);

if ($resultat) {
    echo json_encode(['success' => true, 'message' => 'Voiture retirée des favoris avec succès!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Erreur lors de la suppression des favoris.']);
}

