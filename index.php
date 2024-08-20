<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_id() === '') {
    session_start();
  }

require_once "Model/Model_car.php";
require_once "Controllers/Controller_footer.php";
require_once "Controllers/Controller_contact.php";
require_once "Controllers/Controller_first.php";
require_once "Controllers/Controller_accueil.php";
require_once "Controllers/Controller.php";

// Liste des contrôleurs
$controllers = ["accueil", "first", "contact", "footer","connexion"];
// Nom du contrôleur par défaut
$controller_default = "accueil";

// On teste si le paramètre controller existe et correspond à un contrôleur de la liste $controllers
if (isset($_GET['controller']) and in_array($_GET['controller'], $controllers)) {
    $nom_controller = $_GET['controller'];
} else {
    $nom_controller = $controller_default;
}

// On détermine le nom de la classe du contrôleur
$nom_classe = 'Controller_' . $nom_controller;

// Définir la variable $nom_fichier avec le chemin correct vers le fichier du contrôleur
$nom_fichier = 'Controllers/' . $nom_classe . '.php';

// Si le fichier existe et est accessible en lecture
if (is_readable($nom_fichier)) {
    // On l'inclut et on instancie un objet de cette classe
    include_once $nom_fichier;
    new $nom_classe();
} else {
    // Gérer l'absence du contrôleur de manière appropriée
    die("Contrôleur non trouvé!");
}
