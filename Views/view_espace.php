<?php

require_once 'Utils/functions.php'; 
require_once "Model/Model_car.php";
require_once "Model/Utilisateur.php"; 
require_once 'Utils/credentials.php';

if (session_id() === '') {
    session_start();
}

try {
    $bd = new PDO('mysql:host=localhost;dbname=voiture', 'root', 'Ultime10');
    $bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch (Exception $e) {
    die('Error : ' . $e->getMessage());
  }
  

$model = Model::getModel();
$userInfo = null; 

$isUserLoggedIn = isset($_SESSION['user_id']);
if($isUserLoggedIn) {
    $utilisateurModel = new Utilisateur($bd); 
    $userInfo = $utilisateurModel->getUserById($_SESSION['user_id']);
    $favoris = $model->getFavorisUtilisateur($_SESSION['user_id']);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Espace Membre</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding-top: 60px;
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

        .welcome-message {
            text-align: center;
            margin: 20px auto;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 800px;
            color: #333;
        }

        .welcome-message h1 {
            margin: 0;
            font-size: 2em;
            font-weight: 700;
            color: #2c3e50;
        }

        .welcome-message p {
            margin: 10px 0 0;
            font-size: 1.2em;
            color: #7f8c8d;
        }

        .user-favorites-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .info-container {
            margin-bottom: 20px;
        }
        

        .car-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .car-card {
            border: 1px solid #ccc;
            position: relative;
            border-radius: 8px;
            overflow: hidden;
            width: 300px;
            display: flex;
            flex-direction: column;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            justify-content: space-between;
        }

        .car-image {
            width: 100%;
            height: 200px; /* Fixed height */
            object-fit: cover; /* Ensure the image fits the container without distortion */
        }

        .car-details {
            padding: 15px;
            text-align: center;
        }

        .car-details ul {
            list-style-type: none;
            padding: 0;
        }

        .button-retirer {
            background-color: blue;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: auto;
        }

        .button-retirer:hover {
            background-color: blue;
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
            cursor: pointer;
            font-size: 24px;
        }

        #no-favorites-message-container {
    display: none;
}

#no-favorites-message {
    text-align: center;
    margin: 20px 0;
    font-size: 1.2em;
    color: #7f8c8d;
}

.links-container {
    text-align: center;
    margin: 20px 0;
}

.links-container a {
    display: inline-block;
    margin: 10px 15px;
    padding: 10px 20px;
    background-color: #3498db;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: background-color 0.3s, box-shadow 0.3s;
}

.links-container a:hover {
    background-color: #2980b9;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
}


.not-logged-in-message {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 50vh; 
    text-align: center;
    font-size: 1.5em;
    color: #333;
    margin: 0 20px; 
}

.button-blue {
    padding: 10px 20px;
    border-radius: 5px;
    border: none;
    background-color: #5643fa; /* Couleur bleu */
    color: white; /* Couleur du texte */
    cursor: pointer;
    transition: background 0.3s ease, box-shadow 0.3s ease;
    font-size: 1em;
    text-align: center;
    display: inline-block;
    text-decoration: none; /* Pour supprimer le soulignement si c'est un lien */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Ombre pour donner un effet de profondeur */
    margin-top: 20px; /* Espacement au-dessus du bouton */
}

.button-blue:hover {
    background-color: #4231a1; /* Couleur du bouton au survol */
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2); /* Ombre plus prononcée au survol */
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
        <a href="index.php" class="nav-item" data-target="Accueil">Accueil</a>
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
        <a href="index.php?controller=connexion&action=ESPACE" class="nav-item is-active" title="Espace Membre"><span class="material-symbols-outlined">account_circle</span></a>
    </div>
    <span class="nav-indicator"></span>
</nav>

<div class="welcome-message">
    <h1>Bienvenue dans votre espace membre<?php if ($isUserLoggedIn && $userInfo) { echo ", " . htmlspecialchars($userInfo['nom_utilisateur']); } ?></h1>
    <p>Nous sommes ravis de vous revoir!</p>
</div>

<?php if ($isUserLoggedIn && $userInfo): ?>
    <div class="user-favorites-container">
    <div class="info-container">
            <h2>Informations Personnelles</h2>
            <p>Nom: <?php echo htmlspecialchars($userInfo['nom']); ?></p>
            <p>Prénom: <?php echo htmlspecialchars($userInfo['prenom']); ?></p>
            <p>Pays: <?php echo htmlspecialchars($userInfo['pays']); ?></p>
            <p>Téléphone: <?php echo htmlspecialchars($userInfo['telephone']); ?></p>
            <button id="modifier-info" class="button-blue">Modifier</button>
        </div>
        <form id="form-modifier" method="post" action="modifier_infos.php" style="display: none;">

            <label for="nom_utilisateur">Nom d'utilisateur :</label>
            <input type="text" id="nom_utilisateur" name="nom_utilisateur" value="<?php echo htmlspecialchars($userInfo['nom_utilisateur']); ?>" required><br>
            
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" pattern="[A-Za-zÀ-ÿ\- ]+" title="Le nom ne peut contenir que des lettres, des espaces et des tirets." value="<?php echo htmlspecialchars($userInfo['nom']); ?>" required><br>

            <label for="prenom">Prénom :</label>
            <input type="text" id="prenom" name="prenom" pattern="[A-Za-zÀ-ÿ\- ]+" title="Le prénom ne peut contenir que des lettres, des espaces et des tirets." value="<?php echo htmlspecialchars($userInfo['prenom']); ?>" required><br>

            <label for="pays">Pays :</label>
            <input type="text" id="pays" name="pays" value="<?php echo htmlspecialchars($userInfo['pays']); ?>" required><br>

            <label for="telephone">Téléphone :</label>
            <input type="text" id="telephone" name="telephone" pattern="\d{10}" title="Le numéro de téléphone doit contenir 10 chiffres." value="<?php echo htmlspecialchars($userInfo['telephone']); ?>" required><br>

            <input type="submit" value="Enregistrer les modifications">
        </form>

        <h2>Mes Voitures favorites</h2>
        <div class="car-grid">
            <?php 
                $model = Model::getModel();
                $utilisateurId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
                if (!empty($favoris)): 
                    foreach($favoris as $voiture): 
                        $estFavori = $model->estEnFavoris($utilisateurId, $voiture['id']); ?>
                        <div class="car-card" id="car-<?php echo $voiture['id']; ?>">
                            <img src="<?php echo htmlspecialchars($voiture['lien']); ?>" alt="Image de la voiture" class="car-image">
                            <div class="car-details">
                                <h3><?php echo htmlspecialchars($voiture['marque']) . " - " . htmlspecialchars($voiture['modele']); ?></h3>
                                <ul>
                                    <li>Energie : <?php echo htmlspecialchars($voiture['energie']); ?></li>
                                    <li>Année : <?php echo htmlspecialchars($voiture['annee']); ?></li>
                                    <li>Kilométrage : <?php echo htmlspecialchars($voiture['kilometrage']); ?> km</li>
                                    <li>Prix : <?php echo htmlspecialchars($voiture['prix']); ?> euros</li>
                                    <li><a href="https://drive.google.com/drive/folders/1fI_d1E9vw-chVIMRCdyjP6uL4Dxm6UZ3?usp=sharing">Fiche technique complète</a></li>
                                </ul>
                            </div>
                            <div class="icone-favori-container">
                                <i class="fa fa-heart icone-favori <?php echo $estFavori ? 'fa-solid icone-favori-noir' : 'fa-regular'; ?>" onclick="toggleFavori(<?php echo $voiture['id']; ?>, this)"></i>
                            </div>
                        </div>
                    <?php endforeach; 
                else: ?>
                    <div id="no-favorites-message-container" style="display: block;">
                        <p id="no-favorites-message">Vous n'avez pas encore ajouté de voitures à vos favoris.</p>
                        <div class="links-container">
                            <a href="?controller=first&action=rechercher_voitures">Rechercher un modèle</a>
                            <a href="?controller=first&action=afficher_toutes_voitures">Tous les véhicules en stocks</a>
                        </div>
                    </div>
                <?php endif; ?>
        </div>
        <!-- Conteneur du message de non-favoris toujours présent dans le DOM -->
        <div id="no-favorites-message-container" style="display: none;">
            <p id="no-favorites-message">Vous n'avez pas encore ajouté de voitures à vos favoris.</p>
            <div class="links-container">
                <a href="?controller=first&action=rechercher_voitures">Rechercher un modèle</a>
                <a href="?controller=first&action=afficher_toutes_voitures">Tous les véhicules en stocks</a>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="not-logged-in-message">
        <p>Connectez-vous pour afficher l'espace membre.</p>
        <a class="button-blue" href="index.php?controller=connexion&action=CONNECT">Connexion</a>
    </div>
    </div>
<?php endif; ?>

<script>
    /* JS MENU HAMBURGER */
    document.addEventListener('DOMContentLoaded', () => {
        const hamburger = document.querySelector('.nav-hamburger');
        const navLinks = document.querySelector('.nav-links');

        hamburger.addEventListener('click', () => {
            navLinks.classList.toggle('active');
        });
    });

    /* PARTIE AJOUT:RETIRER FAVORIS */
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
                document.getElementById('car-' + voitureId).remove();
                if (!document.querySelector('.car-card')) {
                    document.getElementById('no-favorites-message-container').style.display = 'block';
                }
            } else {
                element.classList.remove('fa-regular');
                element.classList.add('fa-solid', 'icone-favori-noir');
                document.getElementById('no-favorites-message-container').style.display = 'none';
            }
        } else {
            alert(data.message);
        }
    })
    .catch(error => console.error('Erreur:', error));
}
/*FORMULAIRE MODIFICATION */
document.getElementById('modifier-info').addEventListener('click', function() {
    document.getElementById('form-modifier').style.display = 'block';
    document.getElementById('modifier-info').style.display = 'none';
});

    /* ENLEVER LE CLIC DROIT POUR INSPECTER */
    document.addEventListener('contextmenu', function(event) {
        event.preventDefault();
    });

</script>

</body>
</html>
