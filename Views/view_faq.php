<?php
// Chemin vers le fichier de données FAQ.
$faqFile = 'Utils/faq.txt'; 

// Récupérer les questions et réponses de la FAQ.
$faqs = array_map(function($entry) {
    list($question, $answer) = explode(',', $entry, 2); // Assurez-vous de limiter l'explosion à 2 éléments pour éviter des problèmes si la réponse contient une virgule.
    return ['question' => $question, 'answer' => $answer];
}, file($faqFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES));

require "Model/Utilisateur.php";
require "Utils/credentials.php";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ</title>
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

        /* NAVBAR CSS */
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

        /* Styles pour la section FAQ */
        .faq-entry {
            margin-bottom: 20px;
        }

        .question {
            font-weight: bold;
            cursor: pointer;
            padding: 10px;
            background-color: #f7f7f7;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .answer {
            display: none;
            padding: 10px;
            border-left: 3px solid #3498db;
            background-color: #eef;
            border-radius: 0 5px 5px 5px;
        }
        footer {
    background-color: #fff;
    padding: 20px 20px;
    box-shadow: 0 -10px 40px rgba(211, 240, 255, .8);
    display: flex;
    flex-direction: column;
    align-items: center; /* Centrer le contenu horizontalement */
    flex-wrap: wrap;
    height: auto; /* Ajuster la hauteur automatiquement */
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

.footer-rights {
    color: #83818c;
    margin-top: 10px; /* Espace au-dessus de la ligne "Tous droits réservés" */
    font-size: 0.9em; /* Taille de police légèrement réduite */
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
        <h1>FAQ DE FAST AUTO</h1>
        <div id="faq">
            <?php foreach ($faqs as $index => $faq): ?>
                <div class="faq-entry">
                    <div class="question" onclick="toggleAnswer(this, 'answer-<?= $index ?>')">
                        <?= htmlspecialchars($faq['question']) ?>
                    </div>
                    <div class="answer" id="answer-<?= $index ?>">
                        <?= htmlspecialchars($faq['answer']) ?>
                    </div>
                </div>
            <?php endforeach; ?>
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

        function toggleAnswer(questionElement, answerId) {
            var answer = document.getElementById(answerId);
            if (answer.style.display === 'none') {
                answer.style.display = 'block';
                questionElement.classList.add('active');
            } else {
                answer.style.display = 'none';
                questionElement.classList.remove('active');
            }
        }

        document.addEventListener('contextmenu', function(event) {
            event.preventDefault();
        });
    </script>
</body>
</html>
