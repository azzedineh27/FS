<?php 
require_once "Model/Utilisateur.php";
require_once "Utils/credentials.php"; 
// Requête pour obtenir 6 voitures aléatoires
$query = "SELECT * FROM voitures ORDER BY RAND() LIMIT 6";
$stmt = $bd->query($query);

// Récupération des résultats
$voitures = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    
    <meta charset="UTF-8">
    <title>Page d'Accueil</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <style>
        body {
    font-family: Arial, sans-serif;
    display: flex;
    flex-direction: column; /* Aligner les éléments verticalement */
    min-height: 100vh; /* Au moins 100% de la hauteur de la fenêtre de visualisation */
    margin: 0;
    padding-top: 60px; /* Ajustez cette valeur en fonction de la hauteur réelle de votre navbar */
}

.header {
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
  .swiper-slide img {
                max-width: 100%;
            }
}

/*SLIDER CSS */
.swiper-container {
    width: 100%;
    overflow: hidden;
    margin-bottom: 50px;
}

.swiper-slide {
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    height: 300px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
}

.swiper-slide img {
    display: block;
    max-width: 100%;
    max-height: 200px;
    margin: 0 auto;
    object-fit: cover;
}

.swiper-slide h3 {
    font-size: 18px;
    font-weight: bold;
    margin: 20px 0;
}

.title, .history {
    font-family: "Helvetica", "Arial", sans-serif;
    display: flex;
    flex-direction: column;
    align-items: left;
    justify-content: left;
    text-align: left;
    padding: 20px 0;
    margin-left: 80px;
}

.titre2 {
    text-align: center;
    margin: 30px 0;
}

.titre2 h1 {
    font-family: 'Helvetica', 'Arial', sans-serif;
    font-size: 2.5em;
    color: #333;
    position: relative;
    display: inline-block;
    padding-bottom: 10px;
    margin: 0;
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
}

/*MARQUES POPULAIRES CSS */
.popular-brands {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 15px;
    margin: 20px;
}

.brand {
    border: 1px solid #ccc;
    border-radius: 10px;
    padding: 10px 20px;
    display: flex;
    align-items: center;
    gap: 10px;
    background: white;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.brand img {
    height: 50px;
}

.brand span {
    font-size: 1rem;
    color: #333;
}

.expertise-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 50px;
    flex-wrap: wrap;
}

.car-image-container {
    flex-basis: 50%;
    padding-right: 50px;
}

.car-image {
    width: 100%;
    height: auto;
    max-width: 600px;
    margin-left: 40px;
}

.expertise-details {
    flex-basis: 50%;
    padding-left: 50px;
    max-width: 600px;
    margin-left: auto;
    margin-bottom: 20px;
}

.expertise-details h2 {
    color: #333;
    margin-bottom: 20px;
}

.expertise-list {
    list-style: none;
    padding: 0;
}

.expertise-list li {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
}

.material-symbols-outlined {
    font-size: 24px;
    margin-right: 10px;
}

.expertise-list li .material-symbols-outlined {
    background-color: #c4c4c4;
    border-radius: 50%;
    padding: 10px;
    color: white;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
}

.title-expertise {
    font-size: 30px;
    font-family: "Helvetica", "Arial", sans-serif;
}

.custom-section, .custom-section2 {
    background-position: center;
    background-size: cover;
    padding: 20px;
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 20px auto;
    max-width: 70%;
    border-radius: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    flex-wrap: wrap;
}

.custom-section p, .custom-section2 p {
    margin: 0;
    font-size: 1rem;
    color: #333;
    margin-right: 20px;
}

.custom-button, .custom-button2 {
    background-color: #83818c;
    color: white;
    padding: 10px 20px;
    border-radius: 20px;
    text-decoration: none;
    font-weight: bold;
    transition: background-color 0.3s;
}

.custom-button:hover, .custom-button2:hover {
    background-color: #D8DAE0;
}

.welcome-section {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 20px;
    margin-top: 20px;
    flex-wrap: wrap;
}

.welcome-text {
    flex-basis: 100%;
    padding-right: 20px;
    text-align: center;
    margin-bottom: 20px;
}

/* Styles for footer */
footer {
    background-color: #fff;
    padding: 20px 20px;
    box-shadow: 0 -10px 40px rgba(211, 240, 255, .8);
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    height: 6vh;
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
    <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-W83TC7QS"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
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
        <a href="index.php?controller=connexion&action=ESPACE" class="nav-item" title="Espace Membre"><span class="material-symbols-outlined">account_circle</span></a>
    </div>
    <span class="nav-indicator"></span>
</nav>


    <div class='welcome-section'>
        <div class="welcome-text">
            <h1>Bienvenue sur FAST AUTO !</h1>
            <p>Vous pourrez retrouver toutes les informations sur notre activité <br>et nous espérons que notre contenu saura répondre à vos attentes !</p>
        </div>
    </div>
    <section class="expertise-container">
    <div class="car-image-container">
        <img src="Images/constat-1.jpg" alt="Voiture" class="car-image">
    </div>
    <div class="expertise-details">
        <h2 class="title-expertise">Notre expertise à votre service</h2>
        <ul class="expertise-list">
            <li><span class="material-symbols-outlined">monitoring</span> Une analyse objective des prix</li>
            <li><span class="material-symbols-outlined">support_agent</span> Une visibilité complète sur l'historique du véhicule</li>
            <li><span class="material-symbols-outlined">price_check</span> Votre budget maîtrisé avec notre simulateur de financement</li>
            <li><span class="material-symbols-outlined">phone_in_talk</span> Une projection claire sur les futurs entretiens de votre voiture</li>
        </ul>
    </div>
    </section>

                                                    <!--LE SLIDER -->
<div class="titre2"><h1>Découvrez tous les modèles de voitures dès maintenant.</h1></div>


<div class="custom-section">
    <p>Vous recherchez un modèle précis ?</p>
    <a href="?controller=first&action=rechercher_voitures" class="custom-button">Rechercher un modèle</a>
</div>


<div class="swiper-container">
  <div class="swiper-wrapper">
    <?php foreach ($voitures as $voiture): ?>
      <div class="swiper-slide">
        <img src="<?php echo $voiture['lien']; ?>" alt="Image de la voiture">
        <h3><?php echo $voiture['marque'] . " " . $voiture['modele']; ?></h3>
        <!-- Autres détails de la voiture -->
      </div>
    <?php endforeach; ?>
  </div>
</div> 


<div class="titre2"><h1>Les marques les plus populaires</h1></div>
<section class="popular-brands">
        <div class="brand">
            <img src="Logos\audi.jpg" alt="Audi">
            <span>Audi</span>
        </div>
        <div class="brand">
            <img src="Logos\bmw.jpg" alt="BMW">
            <span>BMW</span>
        </div>
        <div class="brand">
            <img src="Logos\mercedes.jpg" alt="Mercedes">
            <span>Mercedes</span>
        </div>
        <div class="brand">
            <img src="Logos\peugeot.jpg" alt="Peugeot">
            <span>Peugeot</span>
        </div>
        <div class="brand">
            <img src="Logos\renault.jpg" alt="Renault">
            <span>Renault</span>
        </div>
        <div class="brand">
            <img src="Logos\volkswagen.jpg" alt="Volkswagen">
            <span>Volkswagen</span>
        </div>
</section>

<div class="custom-section2">
    <p>Découvrez tous les véhicules en vente ! </p>
    <a href="?controller=first&action=afficher_toutes_voitures" class="custom-button2">Tous les véhicules en stocks </a>
</div>

                                            <!--LE FOOTER --> 
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

// Réinitialiser l'indicateur lors du redimensionnement de la fenêtre
window.addEventListener('resize', () => {
    const activeItem = document.querySelector('.nav-item.is-active');
    setIndicator(activeItem);
});

function ajouterFavori(voitureId) {
    fetch('ajouterFavori.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'voiture_id=' + voitureId
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // L'ajout a réussi
            alert("Voiture ajoutée aux favoris !");
        } else {
            // L'ajout a échoué, vérifiez le message pour déterminer la cause
            if (data.message === 'Voiture déjà dans les favoris.') {
                alert("Voiture déjà dans les favoris.");
            } else if (data.message === 'Vous devez être connecté pour ajouter aux favoris.') {
                alert("Vous devez être connecté pour ajouter aux favoris.");
            } else {
                // Si le message ne correspond à aucun des cas ci-dessus, affichez-le directement
                alert(data.message);
            }
        }
    })
    .catch(error => console.error('Erreur:', error));
}
var mySwiper = new Swiper('.swiper-container', {
  slidesPerView: 3,
  loop: true,
  autoplay: {
    delay: 3000,
  },
  // Assurez-vous que l'option de pagination est configurée pour que les diapositives puissent défiler automatiquement.
  pagination: {
    el: '.swiper-pagination',
    clickable: true,
  },
  breakpoints: {
    499: {
      slidesPerView: 1,
      spaceBetween: 30
    },
    999: {
      slidesPerView: 2,
      spaceBetween: 40
    },
    1200: {
      slidesPerView: 3,
      spaceBetween: 50
    }
  }
});
/* Désactiver le clic droit sur toute la page */
document.addEventListener('contextmenu', function(event) {
        event.preventDefault();
    });
</script>
</body>
</html>