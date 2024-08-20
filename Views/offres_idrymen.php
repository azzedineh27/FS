<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>IDRYMEN - Nos Offres</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        h1 {
            text-align: center;
            color: #4CAF50;
            margin-top: 40px;
        }

        .container {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            padding: 20px;
        }

        .offer {
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 10px;
            width: 30%;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin-bottom: 20px;
            position: relative;
            transition: transform 0.3s;
        }

        .offer:hover {
            transform: translateY(-5px);
        }

        .offer-title {
            font-size: 1.5em;
            color: #4CAF50;
            margin: 20px 0;
        }

        .offer-content {
            padding: 20px;
            display: none;
            text-align: left;
        }

        .offer-button {
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 1em;
            margin-bottom: 20px;
            transition: background-color 0.3s;
        }

        .offer-button:hover {
            background-color: #218838;
        }

        .arrow {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 24px;
            cursor: pointer;
            transition: transform 0.3s;
        }

        .arrow.down {
            transform: rotate(0deg);
        }

        .arrow.up {
            transform: rotate(180deg);
        }
    </style>
</head>

<body>

    <h1>Nos Offres</h1>

    <div class="container">

        <div class="offer" id="offer-entretien">
            <div class="offer-title">Entretien</div>
            <span class="arrow down" onclick="toggleDetails('entretien-details')">&#x25BC;</span>
            <div class="offer-content" id="entretien-details">
                <h3>Étapes de l'entretien</h3>
                <ul>
                    <li>Évaluation de vos plantes existantes</li>
                    <li>Nettoyage régulier des plantes et des pots</li>
                    <li>Arrosage et fertilisation</li>
                    <li>Surveillance de la santé des plantes</li>
                    <li>Remplacement des plantes si nécessaire</li>
                </ul>
            </div>
            <button class="offer-button" onclick="toggleDetails('entretien-details')">Voir Détails</button>
        </div>

        <div class="offer" id="offer-vegetalisation">
            <div class="offer-title">Végétalisation</div>
            <span class="arrow down" onclick="toggleDetails('vegetalisation-details')">&#x25BC;</span>
            <div class="offer-content" id="vegetalisation-details">
                <h3>Étapes de la végétalisation</h3>
                <ul>
                    <li>Consultation et conception personnalisée</li>
                    <li>Sélection des plantes adaptées à votre espace</li>
                    <li>Installation de solutions de végétalisation</li>
                    <li>Optimisation pour un entretien facile</li>
                    <li>Suivi après installation</li>
                </ul>
            </div>
            <button class="offer-button" onclick="toggleDetails('vegetalisation-details')">Voir Détails</button>
        </div>

        <div class="offer" id="offer-complet">
            <div class="offer-title">Végétalisation + Entretien</div>
            <span class="arrow down" onclick="toggleDetails('complet-details')">&#x25BC;</span>
            <div class="offer-content" id="complet-details">
                <h3>Étapes combinées</h3>
                <ul>
                    <li>Conception et installation de la végétalisation</li>
                    <li>Entretien complet régulier des plantes</li>
                    <li>Surveillance de la santé des plantes</li>
                    <li>Remplacement des plantes si nécessaire</li>
                    <li>Support continu pour optimiser la végétalisation</li>
                </ul>
            </div>
            <button class="offer-button" onclick="toggleDetails('complet-details')">Voir Détails</button>
        </div>

    </div>

    <script>
        function toggleDetails(offerId) {
            const details = document.getElementById(offerId);
            const arrow = details.previousElementSibling;

            if (details.style.display === "none" || details.style.display === "") {
                details.style.display = "block";
                arrow.classList.remove("down");
                arrow.classList.add("up");
            } else {
                details.style.display = "none";
                arrow.classList.remove("up");
                arrow.classList.add("down");
            }
        }
    </script>

</body>

</html>
