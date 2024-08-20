<?php
include_once "Controllers/Controller_first.php";
require_once "Model/Utilisateur.php";
require_once "Utils/credentials.php";
include_once "Utils/functions.php";

try {
    $bd = new PDO('mysql:host=localhost;dbname=voiture', 'root', 'Ultime10');
    $bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('Error : ' . $e->getMessage());
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rechercher des Voitures</title>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
body {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
    margin: 0;
    font-family: Arial, sans-serif;
}

.header {
    height: 10vh; /* ou la hauteur fixe en px */
}

.main-content {
    flex: 1; /* Permet au contenu principal de remplir l'espace disponible */
}

/*NAVBAR CSS */
nav {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 20px;
    border-radius: 0;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    background-color: #fff;
    z-index: 1000;
}

.nav-left {
    display: flex;
    align-items: center;
}

.nav-logo {
    height: 50px;
    margin-right: 20px;
}

.nav-links {
    display: flex;
    align-items: center;
    flex-grow: 1;
    justify-content: flex-end;
}

.nav-item {
    color: #83818c;
    padding: 10px;
    margin: 0 6px;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 40px;
    text-decoration: none;
}

.nav-item:before {
    content: "";
    position: absolute;
    bottom: -6px;
    background-color: #dfe2ea;
    height: 5px;
    width: 100%;
    border-radius: 8px 8px 0 0;
    left: 0;
    transition: .3s;
    bottom: 0;
}

.nav-item:not(.is-active):hover:before {
    bottom: 0;
}
.nav-item:not(.is-active):hover {
    color: #333;
}

.nav-indicator {
    position: absolute;
    left: 0;
    bottom: 0;
    height: 5px;
    transition: .4s;
    border-radius: 8px 8px 0 0;
}

.is-active:before {
    background-color: blue;
}

.nav-item .material-symbols-outlined {
    font-size: 24px;
    line-height: 1;
    vertical-align: middle;
}

.site-name {
    font-weight: bold;
    color: #727176;
    font-size: 1.5em;
}

.nav-hamburger {
    display: none;
    font-size: 24px;
    cursor: pointer;
}

@media (max-width: 768px) {
    .nav-links {
        flex-direction: column;
        align-items: center;
        justify-content: center;
        position: absolute;
        top: 60px;
        right: 0;
        background: #fff;
        width: 100%;
        display: none;
    }

    .nav-item {
        margin: 10px 0;
    }

    .nav-hamburger {
        display: block;
    }

    .nav-links.active {
        display: flex;
    }
}

.rechercher {
    text-align: center;
    font-weight: 700;
    font-size: 36px;
    color: #333;
    margin-top: 20px;
    margin-bottom: 20px;
}

@keyframes slideDown {
    from {
        transform: translateY(-100px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

.slide-down-animation {
    animation: slideDown 1s ease forwards;
}

.car-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 20px;
    padding: 20px;
}

.car-card {
    position: relative;
    border: 1px solid #ccc;
    border-radius: 5px;
    overflow: hidden;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.image-container {
    position: relative;
}

.image-container img {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.icone-favori-container {
    position: absolute;
    top: 10px;
    right: 10px;
    background-color: white;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.icone-favori {
    font-size: 24px;
    cursor: pointer;
    z-index: 10;
    color: black;
}

.icone-favori-noir {
    color: black;
}

.car-card h3 {
    margin: 0;
    background-color: #f7f7f7;
    padding: 10px;
    border-bottom: 1px solid #ccc;
}

.car-card ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.car-card ul li {
    padding: 10px;
    border-bottom: 1px solid #eee;
}

.car-card ul li:last-child {
    border: none;
}

.search-bar {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    padding: 20px;
    border-radius: 20px;
    box-shadow: 0 -10px 40px rgba(211, 240, 255, .8);
    background: #fff;
    width: 90%;
    margin: 20px auto;
}

.search-bar form {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    align-items: center;
    justify-content: center;
    margin: auto;
}

.search-bar input[type="text"],
.search-bar input[type="number"] {
    border: 1px solid #cccccc;
    padding: 10px;
    border-radius: 10px;
    outline: none;
}

.search-bar input[type="submit"] {
    background-color: white;
    color: black;
    border: none;
    padding: 10px 20px;
    text-transform: uppercase;
    border-radius: 10px;
    cursor: pointer;
    transition: background-color 0.3s;
    border: 1px solid #cccccc;
}

.search-bar input[type="submit"]:hover {
    background-color: #D3F0FF;
}

@media (max-width: 800px) {
    .search-bar form {
        flex-direction: column;
        max-width: 100%;
    }

    .search-bar input[type="submit"] {
        width: 100%;
    }
}

.form-row.buttons-row {
    justify-content: center;
}

.form-row button, .form-row input[type="submit"], .form-row a.options-button {
    font-size: 16px;
    padding: 10px 20px;
    text-transform: uppercase;
    border-radius: 10px;
    border: 1px solid #cccccc;
    background-color: white;
    color: black;
    cursor: pointer;
    transition: background-color 0.3s;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.form-row button:hover, .form-row input[type="submit"]:hover, .form-row a.options-button:hover {
    background-color: #D3F0FF;
}

#filtresSupplementaires {
    display: flex;
}

#plusOptions {
    color: black;
    cursor: pointer;
    margin-bottom: 10px;
}

footer {
    background-color: #fff;
    padding: 20px 20px;
    box-shadow: 0 -10px 40px rgba(211, 240, 255, .8);
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    height: 6vh;
    margin-top: auto; /* Ajoutez cette ligne */
    max-width: 100%;
}

.footer-container {
    display: flex;
    justify-content: center;
    gap: 20px;
    flex-wrap: wrap;
}

.footer-item {
    color: #83818c;
    padding: 10px;
    margin: 5px;
    border-radius: 5px;
    transition: color 0.3s;
    text-decoration: none;
}

.footer-item:hover {
    color: #333;
    background-color: #f7f7f7;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    text-decoration: none;
}
.footer-fixed-bottom {
    position: fixed;
    bottom: 0;
    width: 100%;
}

.pagination {
    text-align: center;
    margin-top: 20px;
    padding-bottom: 40px;
}

.pagination a, .pagination span {
    margin: 0 5px;
    padding: 8px 16px;
    text-decoration: none;
    border: 1px solid #ddd;
    color: #333;
}

.pagination a.active {
    background-color: #007bff;
    color: white;
    border: 1px solid #007bff;
}

.pagination a:hover:not(.active) {
    background-color: #ddd;
}

.pagination span {
    padding: 8px 16px;
    border: 1px solid #ddd;
    color: #333;
}

.no-results {
    position: absolute;
    top: 60%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 24px;
    color: #333;
    text-align: center;
}

</style>
</head>
<body>
    <header class="header">
                    <!--LA NAVBAR --> 
                    <nav>
        <div class="nav-left">
            <img src="Logos/logo_FINAL.png" alt="FA Logo" class="nav-logo">
            <span class="site-name">FAST AUTO</span>
        </div>
        <div class="nav-hamburger">
            <span class="material-symbols-outlined">menu</span>
        </div>
        <div class="nav-links">
            <a href="index.php" class="nav-item" data-target="Accueil">Accueil</a>
            <a href="index.php?controller=first&action=afficher_toutes_voitures" class="nav-item" data-target="Véhicules">Véhicules</a>
            <a href="index.php?controller=first&action=rechercher_voitures" class="nav-item is-active" data-target="Recherche">Recherche</a>
            <a href="index.php?controller=contact&action=afficher_contact" class="nav-item" data-target="Contact">Contact</a>
            <?php
                if(isset($_SESSION['user_id'])) {
                    $utilisateurModel = new Utilisateur($bd); 
                    $userInfo = $utilisateurModel->getUserById($_SESSION['user_id']);
                    echo '<a href="deconnexion.php" class="nav-item" data-target="Déconnexion">Déconnexion</a>';
                } else {
                    echo '<a href="index.php?controller=connexion&action=CONNECT" class="nav-item" data-target="CONNEXION">Connexion</a>';
                }
            ?>
            <a href="index.php?controller=connexion&action=ESPACE" class="nav-item" title="Espace Membre"><span class="material-symbols-outlined">account_circle</span></a>
        </div>
        <span class="nav-indicator"></span>
    </nav>
    </header>

    <div class="main-content">
        <div class="rechercher">
            <h1>Rechercher un Modèle</h1>
        </div>


        <div class="search-bar">
            <form action="index.php?controller=first&action=rechercher_voitures" method="post">

            <div class="form-row">
            <input list="marques" id="marque" name="marque" type="text" placeholder="Marque : ">
            <datalist id="marques">
                <option value="Audi">
                <option value="BMW">
                <option value="Mercedes">
                <option value="Peugeot">
                <option value="Renault">
                <option value="Volkswagen">
                <!-- Ajoutez d'autres marques ici -->
            </datalist>

            <input list="modeles" id="modele" name="modele" type="text" placeholder="Modèle : ">
            <datalist id="modeles">
                <option value="Golf">
                <option value="A3">
                <option value="Série 1">
                <option value="Classe C">
                <option value="Corolla">
                <option value="Clio 4">
                <option value="Urus">
                <option value="208">
                <option value="Focus">
            </datalist>

            <input list="energies" id="energie" name="energie" type="text" placeholder="Energie">
            <datalist id="energies">
                <option value="Diesel">
                <option value="Essence">
                <option value="Electrique">
            </datalist>

            <input type="number" id="prixMin" name="prixMin" placeholder="Prix Min : " min="0" step="1" pattern="\d*" title="Veuillez entrer un nombre positif.">
            <input type="number" id="prixMax" name="prixMax" placeholder="Prix Max : " min="0" step="1" pattern="\d*" title="Veuillez entrer un nombre positif.">
        </div>

        <div id="filtresSupplementaires" class="form-row" style="display: none;">
            <input type="number" id="anneeMin" name="anneeMin" placeholder="Année Min : " pattern="\d{4}" title="Veuillez entrer une année à 4 chiffres.">
            <input type="number" id="anneeMax" name="anneeMax" placeholder="Année Max : " pattern="\d{4}" title="Veuillez entrer une année à 4 chiffres.">
            <input type="number" id="kmMin" name="kmMin" placeholder="Km Min : " min="0" step="1" pattern="\d*" title="Veuillez entrer un nombre positif.">
            <input type="number" id="kmMax" name="kmMax" placeholder="Km Max : " min="0" step="1" pattern="\d*" title="Veuillez entrer un nombre positif.">
        </div>

            <div class="form-row buttons-row">
                    <a href="#" id="plusOptions" class="options-button" onclick="toggleOptions()">+ Filtres</a>
                    <input type="submit" value="Rechercher" class="submit-btn">
            </div>
            </form>
        </div>

        <div class="car-grid">
            <?php
            $model = Model::getModel();
            $utilisateurId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

            if (!empty($voitures)) :
                foreach ($voitures as $recherche) :
                    $estFavori = $model->estEnFavoris($utilisateurId, $recherche['id']);
            ?>
                    <div class="car-card">
                        <div class="image-container">
                            <img src="<?php echo $recherche['lien']; ?>" alt="Image de la voiture">
                            <div class="icone-favori-container">
                                <i class="fa fa-heart icone-favori <?php echo $estFavori ? 'fa-solid icone-favori-noir' : 'fa-regular'; ?>" onclick="toggleFavori(<?php echo $recherche['id']; ?>, this)"></i>
                            </div>
                        </div>
                        <h3><?php echo $recherche['marque'] . ' ' . $recherche['modele']; ?></h3>
                        <ul>
                            <li>Energie : <?php echo $recherche['energie']; ?></li>
                            <li>Année : <?php echo $recherche['annee']; ?></li>
                            <li>Kilométrage : <?php echo $recherche['kilometrage']; ?> km</li>
                            <li>Prix : <?php echo $recherche['prix']; ?> euros</li>
                            <li><a href="https://drive.google.com/drive/folders/1fI_d1E9vw-chVIMRCdyjP6uL4Dxm6UZ3?usp=sharing">Fiche technique complète</a></li>
                        </ul>
                    </div>
            <?php 
                endforeach; 
            else:
            ?>
                <div class="no-results">
                    Aucun résultat trouvé
                </div>
            <?php 
            endif; 
            ?>
        </div>

        <div class="pagination">
            <?php
            $searchParams = $_SESSION['search'] ?? [];
            $queryString = http_build_query(array_merge($searchParams, ['controller' => 'first', 'action' => 'rechercher_voitures']));
            $range = 3;
            $start = max(1, $currentPage - $range);
            $end = min($totalPages, $currentPage + $range);

            if ($currentPage > 1) {
                echo '<a href="index.php?' . $queryString . '&page=' . ($currentPage - 1) . '">&laquo; Précédent</a>';
            }

            if ($start > 1) {
                echo '<a href="index.php?' . $queryString . '&page=1">1</a>';
                if ($start > 2) {
                    echo '<span>...</span>';
                }
            }

            for ($i = $start; $i <= $end; $i++) {
                if ($i == $currentPage) {
                    echo '<a class="active" href="index.php?' . $queryString . '&page=' . $i . '">' . $i . '</a>';
                } else {
                    echo '<a href="index.php?' . $queryString . '&page=' . $i . '">' . $i . '</a>';
                }
            }

            if ($end < $totalPages) {
                if ($end < $totalPages - 1) {
                    echo '<span>...</span>';
                }
                echo '<a href="index.php?' . $queryString . '&page=' . $totalPages . '">' . $totalPages . '</a>';
            }

            if ($currentPage < $totalPages) {
                echo '<a href="index.php?' . $queryString . '&page=' . ($currentPage + 1) . '">Suivant &raquo;</a>';
            }
            ?>
        </div>




    <footer>
        <div class="footer-container">
            <a href="index.php?controller=footer&action=QSN" class="footer-item">Qui sommes-nous</a>
            <a href="index.php?controller=footer&action=RGPD" class="footer-item">Politique de confidentialité</a>
            <a href="index.php?controller=contact&action=afficher_contact" class="footer-item">Contact</a>
            <a href="index.php?controller=footer&action=FAQ" class="footer-item">FAQ</a>
        </div>
</footer>
<script>
            /*JS MENU HAMBURGER */
document.addEventListener('DOMContentLoaded', () => {
    const hamburger = document.querySelector('.nav-hamburger');
    const navLinks = document.querySelector('.nav-links');

    hamburger.addEventListener('click', () => {
        navLinks.classList.toggle('active');
    });
});
document.addEventListener('DOMContentLoaded', function() {
    // Sélectionnez le titre h1 par son texte
    const title = document.querySelector('h1');
    // Ajoutez la classe d'animation au titre
    title.classList.add('slide-down-animation');
});

function toggleOptions() {
    var optionsDiv = document.getElementById("filtresSupplementaires");
    var optionsLink = document.getElementById("plusOptions");
    var isPlusIcon = optionsLink.textContent.trim() === '+ Filtres'; // Utilise textContent pour vérifier le texte

    if (optionsDiv.style.display === "none") {
        optionsDiv.style.display = "block";
        if (isPlusIcon) {
            optionsLink.textContent = '- Filtres'; // Modifie le texte pour indiquer la fermeture des filtres
        }
    } else {
        optionsDiv.style.display = "none";
        if (!isPlusIcon) {
            optionsLink.textContent = '+ Filtres'; // Modifie le texte pour indiquer l'ouverture des filtres
        }
    }
}
/*PARTIE GERER FAVORIS */
function toggleFavori(voitureId, element) {
    const estFavori = element.classList.contains('fa-solid');
    const action = estFavori ? 'supprimerFavori.php' : 'ajouterFavori.php';

    fetch(action, {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'voiture_id=' + voitureId
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (estFavori) {
                element.classList.remove('fa-solid', 'icone-favori-noir');
                element.classList.add('fa-regular');
            } else {
                element.classList.remove('fa-regular');
                element.classList.add('fa-solid', 'icone-favori-noir');
            }
        } else {
            alert(data.message);
        }
    })
    .catch(error => console.error('Erreur:', error));
}
/*FOOTER FIXED AVEC AUCUN RESULTAT ET MESSAGE */

document.addEventListener('DOMContentLoaded', function() {
    var carGrid = document.querySelector('.car-grid');
    var footer = document.querySelector('footer');
    var noResults = document.querySelector('.no-results');
    
    if (carGrid.children.length === 0 || noResults) {
        footer.classList.add('footer-fixed-bottom');
    } else {
        footer.classList.remove('footer-fixed-bottom'); // Enlever la classe si des résultats sont présents
    }
});

/*ENLEVER LE CLIC DROIT POUR INSPECTER */
document.addEventListener('contextmenu', function(event) {
        event.preventDefault();
    });
    </script>
</body>
</html>
