<?php 
require_once "Model\Utilisateur.php"; 
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Politique de confidentialité</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
    margin: 0;
    font-family: Arial, sans-serif;
    background-color: #f9f9f9; /* Arrière-plan gris clair */
    color: #333; /* Couleur de texte principale */
}

.header {
    height: 10vh;
}

.main-content {
    flex: 1;
    padding: 40px; /* Plus de padding pour plus d'espace */
    background-color: #fff; /* Arrière-plan blanc pour le contenu principal */
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Légère ombre pour le contenu principal */
    margin: 20px auto; /* Centrer le contenu avec des marges automatiques */
    max-width: 800px; /* Limite de largeur pour le contenu principal */
    border-radius: 8px; /* Coins légèrement arrondis */
}

h1, h2 {
    color: #1a1a1a; /* Couleur de titre foncé */
    font-family: 'Helvetica', 'Arial', sans-serif;
}

h1 {
    font-size: 2.5em;
    margin-bottom: 20px;
    text-align: center; /* Centrer le titre principal */
}

h2 {
    font-size: 1.75em;
    margin-top: 20px;
}

p, ul {
    line-height: 1.6; /* Améliore la lisibilité */
    font-size: 1.1em;
    margin: 10px 0;
}

ul {
    padding-left: 20px; /* Indentation des listes */
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

footer {
    background-color: #fff;
    padding: 20px 20px;
    box-shadow: 0 -10px 40px rgba(211, 240, 255, .8);
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    height: 6vh;
    text-decoration: none;
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

    </style>
</head>
<body>
    <header class="header">
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
                <a href="index.php?controller=connexion&action=ESPACE" class="nav-item" title="Espace Membre">
                    <span class="material-symbols-outlined">account_circle</span>
                </a>
            </div>
            <span class="nav-indicator"></span>
        </nav>
    </header>
    <div class="main-content">
        <h1>Politique de Protection des Données Personnelles</h1>
        <p>Nous, FAST AUTO, traitons des données à caractère personnel vous concernant en tant que responsable de traitement dans le cadre de l’utilisation de notre site internet.</p>

        <p>Nous respectons votre vie privée et protégeons vos données à caractère personnel conformément à la législation en vigueur, notamment la loi 78-17 du 6 janvier 1978 relative à l'informatique, aux fichiers et aux libertés et le règlement (UE) 2016/679 du 27 avril 2016 relatif à la protection des données personnelles (le "RGPD").</p>

        <h2>Données Collectées</h2>
        <p>Nous collectons les données personnelles suivantes :</p>
        <ul>
            <li>Données d'identité : nom, prénom, adresse, courriel.</li>
            <li>Données démographiques : sexe, âge.</li>
            <li>Données de géolocalisation (avec votre consentement).</li>
            <li>Données d'authentification : identifiant et mot de passe.</li>
            <li>Données de connexion : date et heure de connexion, durée de connexion, pages vues.</li>
            <li>Données de navigation : adresse IP, type de terminal utilisé, système d'exploitation.</li>
        </ul>

        <h2>Bases Légales du Traitement</h2>
        <p>Nous traitons vos données personnelles sur les bases légales suivantes :</p>
        <ul>
            <li>Le contrat : pour l'exécution des contrats que vous avez souscrits avec nous.</li>
            <li>Le consentement : lorsque vous avez donné votre consentement explicite.</li>
            <li>L'intérêt légitime : pour améliorer nos services et vous offrir une meilleure expérience utilisateur.</li>
            <li>La loi : pour nous conformer à nos obligations légales.</li>
        </ul>

        <h2>Finalités du Traitement</h2>
        <p>Nous utilisons vos données pour les finalités suivantes :</p>
        <ul>
            <li>Gestion de votre compte utilisateur et authentification.</li>
            <li>Gestion des commandes et des paiements.</li>
            <li>Communication et gestion de la relation client.</li>
            <li>Sécurité des services et lutte contre la fraude.</li>
            <li>Marketing direct et envoi de newsletters (avec votre consentement).</li>
            <li>Analyse de l’audience et amélioration de nos services.</li>
        </ul>

        <h2>Destinataires des Données</h2>
        <p>Vos données personnelles sont destinées à :</p>
        <ul>
            <li>Nos services internes et personnels habilités.</li>
            <li>Nos filiales et partenaires commerciaux.</li>
            <li>Nos sous-traitants dans le respect des finalités définies.</li>
            <li>Autorités légales et administratives lorsque requis.</li>
        </ul>

        <h2>Transfert des Données</h2>
        <p>Vos données personnelles peuvent être transférées hors de l'Union européenne avec des garanties appropriées pour assurer leur protection, telles que des clauses contractuelles types.</p>

        <h2>Durée de Conservation</h2>
        <p>Nous conservons vos données personnelles pendant la durée nécessaire aux finalités pour lesquelles elles ont été collectées :</p>
        <ul>
            <li>Données de compte inactif : 3 ans après la dernière interaction.</li>
            <li>Données de commande : 10 ans après la dernière commande.</li>
        </ul>

        <h2>Vos Droits</h2>
        <p>Vous disposez des droits suivants :</p>
        <ul>
            <li>Droit d'accès : obtenir des informations sur les données personnelles détenues vous concernant.</li>
            <li>Droit de rectification : corriger les données inexactes.</li>
            <li>Droit d'effacement : demander la suppression des données.</li>
            <li>Droit à la limitation : restreindre le traitement de vos données.</li>
            <li>Droit à la portabilité : recevoir une copie de vos données dans un format structuré.</li>
            <li>Droit d'opposition : vous opposer au traitement de vos données pour des motifs légitimes.</li>
        </ul>

        <p>Pour exercer vos droits, veuillez nous contacter à [adresse e-mail] ou par la page de contact, accompagné d'une copie de votre pièce d'identité.</p>

        <h2>Sécurité des Données</h2>
        <p>Nous mettons en œuvre des mesures techniques et organisationnelles pour protéger vos données contre les accès non autorisés, les pertes, altérations ou divulgations.</p>

        <h2>Mise à Jour de la Politique</h2>
        <p>Cette politique de confidentialité peut être modifiée à tout moment. Nous vous invitons à la consulter régulièrement.</p>

        <h2>Contact</h2>
        <p>Pour toute question, vous pouvez nous contacter à [adresse e-mail] ou par courrier à [adresse postale].</p>

        <p>Dernière mise à jour : 28/06/2024.</p>
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

        document.addEventListener('contextmenu', function(event) {
            event.preventDefault();
        });
    </script>
</body>
</html>
