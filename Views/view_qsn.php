<?php 
require_once "Model\Utilisateur.php"; 

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Qui sommes-nous</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            color: #333;
            padding-top: 30px; /* Ajustez cette valeur en fonction de la hauteur réelle de votre navbar */
        }

.header {
    /* Supposons que le header a une hauteur fixe */
    height: 10vh; /* ou la hauteur fixe en px */
}

.main-content {
    flex: 1;
    padding-bottom: 20px;
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
        
.content {
            padding: 20px;
            max-width: 1200px; /* Largeur maximale du contenu pour le centrer */
            margin: auto;
        }
        .txt-grp, .txt-equipe {
            font-size: 16px; /* Taille de police ajustée pour la lisibilité */
            line-height: 1.6; /* Espacement des lignes pour améliorer la lisibilité */
            color: #555; /* Couleur du texte ajustée */
        }
        .titre-grp {
            font-size: 24px; /* Augmentation de la taille pour les titres */
            color: #333; /* Couleur du texte pour les titres */
            margin-bottom: 20px; /* Espacement avant le texte */
        }
        .histoire {
            padding: 50px 20px; /* Espacement autour de la section histoire */
        }
        .histoire-texte {
            flex: 1;
            min-width: 300px; /* Largeur minimale pour éviter que le texte ne soit trop serré */
        }
        .image-equipe, .image-cinema {
    flex-basis: 400px; /* Largeur de base pour les images */
    max-width: 100%; /* Largeur maximale pour les images */
    width: 100%; /* Permet aux images d'être responsives */
    height: auto; /* Conserve le ratio des images */
    border-radius: 10px; /* Adoucit les coins des images */
    object-fit: cover; /* Ajuste l'image pour couvrir le conteneur sans déformation */
    margin-top: 20px; /* Décale la première image vers le bas */
}

.histoire-section img {
    max-width: 100%; /* Assure que les images ne dépassent pas le conteneur */
    max-height: 400px; /* Limite la hauteur maximale des images */
    object-fit: cover; /* Assure que les images gardent leurs proportions */
}

.histoire-section {
    display: flex;
    flex-wrap: wrap; /* Permet aux éléments de passer à la ligne sur les petits écrans */
    align-items: flex-start; /* Aligne les éléments au début verticalement */
    gap: 20px; /* Espacement entre les éléments */
}




    </style>
</head>
<body>

<nav>
    <div class="nav-left">
        <img src="Logos/logo_FINAL.png" alt="FA Logo" class="nav-logo">
        <span class="site-name">FAST AUTO</span>
    </div>
    <div class="nav-hamburger">
        <span class="material-symbols-outlined">menu</span>
    </div>
    <div class="nav-links">
        <a href="index.php" class="nav-item is-active" data-target="Accueil">Accueil</a>
        <a href="index.php?controller=first&action=afficher_toutes_voitures" class="nav-item" data-target="Véhicules">Véhicules</a>
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
        <a href="espace_membre.php" class="nav-item" title="Espace Membre"><span class="material-symbols-outlined">account_circle</span></a>
    </div>
    <span class="nav-indicator"></span>
</nav>


<div class="content">
    <div class="histoire">
        <div class="histoire-section">
            <div class="histoire-texte">
                <div class="titre-grp">
                    <h1>Qui sommes-nous</h1>
                </div>
                <div class="txt-equipe">
                    <p>Bonjour à tous, nous sommes l'équipe de FAST AUTO et nous vous souhaitons la bienvenue ! En parcourant les différentes pages,
                        vous pourrez retrouver une sélection complète de voitures ainsi que les informations les concernant.</p>
                </div>
            </div>
            <div class="image-equipe">
                <img src="Images/qsn_3.png" alt="Notre équipe">
            </div>
        </div>
        <div class="histoire">
            <div class="histoire-section">
                <div class="histoire-texte">
                    <div class="titre-grp">
                        <h1>Notre histoire</h1>
                    </div>
                    <div class="txt-grp">
                        <p>Depuis notre création en 2024, notre objectif a toujours été de fournir à nos utilisateurs une expérience automobile unique. Nous combinons passion et expertise technique pour créer un site qui va au-delà de la simple consultation de véhicules. Notre voyage a commencé dans une petite salle, et aujourd'hui, nous sommes fiers de toucher des milliers de passionnés à travers le pays.</p>
                    </div>
                </div>
                <div class="image-cinema">
                    <img src="Images/qsn_4.png" alt="Notre histoire">
                </div>
            </div>
        </div>
        <!-- Fin de la section "Notre histoire" -->

    </div>
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
    document.addEventListener('DOMContentLoaded', () => {
    const hamburger = document.querySelector('.nav-hamburger');
    const navLinks = document.querySelector('.nav-links');

    hamburger.addEventListener('click', () => {
        navLinks.classList.toggle('active');
    });
});

/*ENLEVER LE CLIC DROIT POUR INSPECTER */
document.addEventListener('contextmenu', function(event) {
        event.preventDefault();
    });
</script>