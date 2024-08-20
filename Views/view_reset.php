<?php
// Inclure les fichiers nécessaires
include_once "Model/Utilisateur.php";
include_once "Utils/credentials.php";

// Créer une instance du modèle Utilisateur
$utilisateurModel = new Utilisateur($bd);

// Initialiser la variable $message à une chaîne vide par défaut
$message = '';
// Vérifier si le formulaire de réinitialisation du mot de passe a été soumis
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Récupérer les données du formulaire
    $nom = $_POST['nom'];
    $username = $_POST['nom_utilisateur'];
    $nouveauMotDePasse = $_POST['mot_de_passe'];

    // Vérifier si le nom et le nom d'utilisateur correspondent à un utilisateur
    $utilisateur = $utilisateurModel->verifierPersonne($nom, $username);
    if ($utilisateur) {
        // Si l'utilisateur existe, changer le mot de passe
        $resultat = $utilisateurModel->changerMotDePasse($nom, $username, $nouveauMotDePasse);
        $message = "Réinitialisation réussie !"; 
        $success = true;
    } else {
        $message = "Erreur lors de la réinitialisation du mot de passe.";
        $success = false;
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialiser le mot de passe</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <style>

body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding-top: 60px; /* Ajustez cette valeur en fonction de la hauteur réelle de votre navbar */
    font-family: Arial, sans-serif;
    background: url('fondblanc.jpg') no-repeat center center fixed;
    background-size: cover;
    margin: 0;
    padding: 0;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
        }
        body {
    display: flex;
    flex-direction: column; /* Aligner les éléments verticalement */
    min-height: 100vh; /* Au moins 100% de la hauteur de la fenêtre de visualisation */
    margin: 0;
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
.form-reset {
            background: rgba(255, 255, 255, 0.15);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
            color: grey;
            width: 300px;
            margin: auto; /* Centre le formulaire horizontalement */
        }

        .form-reset input[type="text"],
        .form-reset input[type="password"] {
            width: 92%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .form-reset button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            background: #5643fa;
            color: white;
            cursor: pointer;
        }

        .form-reset button:hover {
            background: #4231a1;
        }

        .notification {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(255, 255, 255, 0.9); /* Arrière-plan légèrement teinté */
            color: #333; /* Couleur de texte sombre pour une meilleure lisibilité */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1); /* Ombre douce */
            opacity: 1;
            transition: opacity 0.5s ease;
            animation: fadeIn 0.5s ease; /* Animation d'apparition */
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translate(-50%, -50%) scale(0.8);
            }
            to {
                opacity: 1;
                transform: translate(-50%, -50%) scale(1);
            }
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
                echo '<a href="index.php?controller=connexion&action=CONNECT" class="nav-item is-active" data-target="CONNEXION">Connexion</a>';
            }
        ?>
        <a href="index.php?controller=connexion&action=ESPACE" class="nav-item" title="Espace Membre"><span class="material-symbols-outlined">account_circle</span></a>
    </div>
    <span class="nav-indicator"></span>
</nav>

<div class="form-reset">
        <h2>Réinitialiser le mot de passe</h2>
        <form id="reset-form" method="post">
            <input type="text" name="nom" placeholder="Nom" pattern="[A-Za-zÀ-ÿ\- ]+" title="Le nom ne peut contenir que des lettres, des espaces et des tirets." required>
            <input type="text" name="nom_utilisateur" placeholder="Nom d'utilisateur" pattern="[A-Za-z0-9_]{3,15}" title="Le nom d'utilisateur doit contenir entre 3 et 15 caractères et ne peut contenir que des lettres, des chiffres et des underscores (_)." required>
            <input type="password" name="mot_de_passe" placeholder="Nouveau mot de passe" pattern=".{6,}" title="Le mot de passe doit contenir au moins 6 caractères." required>
            <button type="submit">Réinitialiser le mot de passe</button>
        </form>

</div>
    <?php if (!empty($message)) : ?>
        <div id="message-container" class="notification">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <script>
        /*JS MENU HAMBURGER */
document.addEventListener('DOMContentLoaded', () => {
    const hamburger = document.querySelector('.nav-hamburger');
    const navLinks = document.querySelector('.nav-links');

    hamburger.addEventListener('click', () => {
        navLinks.classList.toggle('active');
    });
});

document.addEventListener('DOMContentLoaded', () => {
    <?php if (isset($message)) { ?>
        var notification = document.getElementById('message-container');
        notification.style.display = 'block';
        setTimeout(function(){
            notification.style.opacity = '0';
            setTimeout(function(){
                notification.style.display = 'none';
            }, 1000); // Temps de la transition en millisecondes
        }, 2000); // Attendre 1,5 seconde avant de commencer à réduire l'opacité
    <?php } ?>
});
/*ENLEVER LE CLIC DROIT POUR INSPECTER */
document.addEventListener('contextmenu', function(event) {
        event.preventDefault();
    });
    </script>
</body>
</html>