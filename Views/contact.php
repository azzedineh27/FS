<?php 
// Connexion à la base de données
require_once "Utils/credentials.php"; 
require_once "Model/Utilisateur.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $tel = $_POST['tel']; 
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'azzedinehatem@gmail.com'; // Utilisez votre adresse e-mail réelle
        $mail->Password = 'mdp'; // Utilisez votre mot de passe réel ou mot de passe d'application
        $mail->SMTPSecure = 'tls'; 
        $mail->Port = 587;

        $mail->setFrom('azzedinehatem@gmail.com', 'Expediteur'); // Utilisez votre adresse e-mail réelle comme expéditeur
        $mail->addAddress('azzedinehatem@gmail.com', 'Nom du Destinataire');

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = "Message de : $name <br>Email: $email<br>Téléphone: $tel<br><br>$message";
        $mail->AltBody = "Message de : $name \nEmail: $email\nTéléphone: $tel\n\n$message"; 

        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );        

        $mail->send();
        $message = 'Message envoyé avec succès !';
    } catch (Exception $e) {
        echo 'Message non envoyé. Erreur: ', $mail->ErrorInfo;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Contactez-nous</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding-top: 60px; /* Pour la navbar */
            background: url('/SITE_WEB/Images/fondblanc3.jpg') no-repeat center center fixed; 
            background-size: cover;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
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

        .formulaire-section {
            background: rgba(255, 255, 255, 0.8);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            width: 80%; /* Ajuster la largeur du formulaire */
            max-width: 600px; /* Limiter la largeur maximale */
        }

        .formulaire-section h2 {
            margin-bottom: 20px;
            font-size: 1.8em;
            text-align: center;
            color: #5643fa; /* Couleur personnalisée pour le titre */
            font-weight: bold;
        }

        .formulaire-section form {
            display: grid;
            grid-gap: 15px; /* Espacement entre les éléments */
        }

        .formulaire-section label {
            font-weight: bold;
        }

        .formulaire-section input[type="text"],
        .formulaire-section input[type="tel"],
        .formulaire-section input[type="email"],
        .formulaire-section textarea {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            transition: border-color 0.3s ease; /* Transition pour l'animation du focus */
            resize: none;
        }

        .formulaire-section input[type="text"]:focus,
        .formulaire-section input[type="email"]:focus,
        .formulaire-section textarea:focus {
            border-color: #5643fa; /* Couleur personnalisée pour le focus */
        }

        .formulaire-section button[type="submit"] {
            padding: 10px 20px;
            border-radius: 5px;
            border: none;
            background-color: #5643fa;
            color: white;
            cursor: pointer;
            transition: background 0.3s ease;
            width: 100%; /* Prendre toute la largeur disponible */
        }

        .formulaire-section button[type="submit"]:hover {
            background-color: #4231a1;
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
        <a href="index.php?controller=contact&action=afficher_contact" class="nav-item is-active" data-target="Contact">Contact</a>
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



<div class="formulaire-section">
    <h2>Contactez-nous</h2>
    <form method="post">
        <label for="name">Nom:</label>
        <input type="text" id="name" name="name" pattern="[A-Za-zÀ-ÿ\s\-']+" title="Le nom ne peut contenir que des lettres, des espaces, des tirets et des apostrophes." required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Veuillez entrer une adresse e-mail valide." required>

        <label for="tel">Téléphone:</label>
        <input type="tel" id="tel" name="tel" pattern="\d{10}" title="Le numéro de téléphone doit contenir 10 chiffres." required>

        <label for="subject">Sujet:</label>
        <input type="text" id="subject" name="subject" pattern="[A-Za-zÀ-ÿ0-9\s\-']+" title="Le sujet ne peut contenir que des lettres, des chiffres, des espaces, des tirets et des apostrophes." required>

        <label for="message">Message:</label>
        <textarea id="message" name="message" rows="4" pattern="[A-Za-zÀ-ÿ0-9\s\.,\-']+" title="Le message ne peut contenir que des lettres, des chiffres, des espaces, des points, des virgules, des tirets et des apostrophes." required></textarea>

        <button type="submit" name="submit">Envoyer</button>
    </form>

    <div id="message-container" class="notification">
    <?php if (isset($message)) { ?>
        <?php echo $message; ?>
    <?php } ?>
</div>
    

</div>
    

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
