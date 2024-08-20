<?php
require_once "Model/Utilisateur.php";
require_once "Utils/credentials.php";

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste de toutes les voitures</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <style>
        body {
            margin: 0;
            padding-top: 60px;
            display: flex;
            flex-direction: column; /* Aligner les éléments verticalement */
            min-height: 100vh; /* Au moins 100% de la hauteur de la fenêtre de visualisation */
            font-family: Arial, sans-serif;
        }

.header {
    /* Supposons que le header a une hauteur fixe */
    height: 10vh; /* ou la hauteur fixe en px */
}

.main-content {
    flex: 1; /* Permet au contenu principal de remplir l'espace disponible */
    padding-bottom: 20px; /* Ajoutez un padding en bas si nécessaire */
}


   /*NAVBAR CSS */
nav {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    display: flex;
    align-items: center;
    justify-content: space-between; /* Assure une répartition équitable de l'espace */
    padding: 0 20px;
    border-radius: 0; /* Supprimez le border-radius ou ajustez-le selon votre design */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    background-color: #fff;
    z-index: 1000; /* S'assure que la navbar reste au-dessus des autres éléments */
}

.nav-left {
    display: flex;
    align-items: center;
}

.nav-logo {
    height: 50px;
    margin-right: 20px; /* Espace entre le logo et le nom du site */
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
        
        /* Ici on met juste un petit élément avant chaque élément pour le rendre plus beau visuellement */
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
            bottom: 0; /* Alignez l'indicateur au bas du .nav-item */
        }
        
        /* Avec les dernières nouveautés de CSS, on peut changer les propriétés des éléments selon des conditions avec not */
        .nav-item:not(.is-active):hover:before {
            bottom: 0;
        }
        .nav-item:not(.is-active):hover {
            color: #333;
        }
        
        /* Stylisons notre indicateur */
        .nav-indicator {
            position: absolute;
            left: 0;
            bottom: 0;
            height: 5px;
            transition: .4s;
            border-radius: 8px 8px 0 0;
        }


        /* Ajustement pour ne pas changer l'indicateur de "Accueil" lors du survol */
        .is-active:before {
            background-color: blue; /* Couleur de l'indicateur pour l'élément actif "Accueil" */
        }

        .nav-item .material-symbols-outlined {
            font-size: 24px; /* La taille de l'icône */
            line-height: 1; /* Cela enlève tout espace supplémentaire au-dessus et en dessous de l'icône */
            vertical-align: middle; /* Cela peut aider à aligner l'icône avec le texte si nécessaire */
        }

        .site-name {
            font-weight: bold;
            color: #727176;
            font-size: 1.5em;
        }

/* Menu hamburger caché par défaut */
.nav-hamburger {
  display: none;
  font-size: 24px; /* Taille de l'icône du menu hamburger */
  cursor: pointer;
}

/* Style des liens de la navbar pour les écrans de petite taille */
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

  /* Lorsque la classe 'active' est ajoutée au menu (lorsqu'on clique sur le menu hamburger) */
  .nav-links.active {
    display: flex;
  }
}

        .title, .history {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 20px 0;
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

        .car-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
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

        .car-card .icone-favori-container {
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

            .car-card .icone-favori {
                font-size: 24px;
                cursor: pointer;
                z-index: 10;
                color: black;
            }

            .car-card .icone-favori-noir {
                color: black;
            }


        .rechercher {
            text-align: center;
            font-family: 'Roboto', sans-serif;
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

        /* Styles for footer */
        footer {
    background-color: #fff;
    padding: 20px 20px;
    box-shadow: 0 -10px 40px rgba(211, 240, 255, .8);
    display: flex;
    justify-content: center; /* Centrage des éléments */
    flex-wrap: wrap; /* Permet aux éléments de passer à la ligne si nécessaire */
    height: 6vh; /* ou la hauteur fixe en px */
    text-decoration: none;
}


.footer-container {
    display: flex;
    justify-content: center;
    gap: 20px; /* Espace entre les éléments */
    flex-wrap: wrap; /* S'assure que les éléments passent à la ligne sur les petits écrans */
}

.footer-item {
    color: #83818c;
    padding: 10px;
    margin: 5px;
    border-radius: 5px;
    transition: color 0.3s;
    text-decoration: none; /* Supprime le soulignement des liens */
}

.footer-item:hover {
    color: #333;
    background-color: #f7f7f7; /* Ajout d'un fond légèrement différent au survol */
    box-shadow: 0 2px 5px rgba(0,0,0,0.1); /* Ajout d'une petite ombre pour un effet de "levage" */
    text-decoration: none;
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
}
    </style>
</head>
<body>
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
            <a href="index.php?controller=first&action=afficher_toutes_voitures" class="nav-item is-active" data-target="Véhicules">Véhicules</a>
            <a href="index.php?controller=first&action=rechercher_voitures" class="nav-item" data-target="Recherche">Recherche</a>
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
    <div class="rechercher">
        <h1>Tous nos Véhicules</h1>
    </div>

    <div class="car-grid">
    <?php
        $model = Model::getModel();
        $utilisateurId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

        foreach ($voitures as $voiture) {
            $estFavori = $model->estEnFavoris($utilisateurId, $voiture['id']);
            ?>
            <div class="car-card">
                <img src="<?php echo htmlspecialchars($voiture['lien']); ?>" alt="Image de la voiture">
                <h3><?php echo htmlspecialchars($voiture['marque']); ?> - <?php echo htmlspecialchars($voiture['modele']); ?></h3>
                <ul>
                    <li>Energie : <?php echo htmlspecialchars($voiture['energie']); ?></li>
                    <li>Année : <?php echo htmlspecialchars($voiture['annee']); ?></li>
                    <li>Kilométrage : <?php echo htmlspecialchars($voiture['kilometrage']); ?> km</li>
                    <li>Prix : <?php echo htmlspecialchars($voiture['prix']); ?> euros</li>
                    <li><a href="https://drive.google.com/drive/folders/1fI_d1E9vw-chVIMRCdyjP6uL4Dxm6UZ3?usp=sharing">Fiche technique complète</a></li>
                </ul>
                <div class="icone-favori-container">
                    <i class="fa fa-heart icone-favori <?php echo $estFavori ? 'fa-solid icone-favori-noir' : 'fa-regular'; ?>" onclick="toggleFavori(<?php echo $voiture['id']; ?>, this)"></i>
                </div>
            </div>

            <?php
        }
    ?>
    </div>

    <div class="pagination">
        <?php
        $range = 3; // Nombre de pages à afficher autour de la page actuelle
        $start = max(1, $currentPage - $range);
        $end = min($totalPages, $currentPage + $range);

        if ($currentPage > 1) {
            echo '<a href="?controller=first&action=afficher_toutes_voitures&page=' . ($currentPage - 1) . '">&laquo; Précédent</a>';
        }

        if ($start > 1) {
            echo '<a href="?controller=first&action=afficher_toutes_voitures&page=1">1</a>';
            if ($start > 2) {
                echo '<span>...</span>';
            }
        }

        for ($i = $start; $i <= $end; $i++) {
            if ($i == $currentPage) {
                echo '<a class="active" href="?controller=first&action=afficher_toutes_voitures&page=' . $i . '">' . $i . '</a>';
            } else {
                echo '<a href="?controller=first&action=afficher_toutes_voitures&page=' . $i . '">' . $i . '</a>';
            }
        }

        if ($end < $totalPages) {
            if ($end < $totalPages - 1) {
                echo '<span>...</span>';
            }
            echo '<a href="?controller=first&action=afficher_toutes_voitures&page=' . $totalPages . '">' . $totalPages . '</a>';
        }

        if ($currentPage < $totalPages) {
            echo '<a href="?controller=first&action=afficher_toutes_voitures&page=' . ($currentPage + 1) . '">Suivant &raquo;</a>';
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

        /*PARTIE AJOUT:RETIRER FAVORIS */
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
                    // Si l'opération sur les favoris est un succès, mettez à jour l'icône
                    if (estFavori) {
                        element.classList.remove('fa-solid', 'icone-favori-noir');
                        element.classList.add('fa-regular');
                    } else {
                        element.classList.remove('fa-regular');
                        element.classList.add('fa-solid', 'icone-favori-noir');
                    }
                } else {
                    alert(data.message); // Ce message est renvoyé par le serveur
                }
            })
            .catch(error => console.error('Erreur:', error));
        }

        /*PARTIE ANIMATION TITRE VOITURE*/ 
        document.addEventListener('DOMContentLoaded', function() {
            const title = document.querySelector('h1');
            title.classList.add('slide-down-animation');
        });
        /*ENLEVER LE CLIC DROIT POUR INSPECTER */
    document.addEventListener('contextmenu', function(event) {
        event.preventDefault();
    });
    </script>
</body>
</html>
