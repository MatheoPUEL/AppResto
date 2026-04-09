<?php
$title = "Accueil";
session_start();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <?php
    require_once('./inc/head.inc.php')
        ?>
</head>

<body>
    <?php
    require_once('./inc/nav.inc.php')
        ?>
    <div class="header">
        <div class="header-title">
            <h2 data-aos="fade-up" data-aos-delay="150">Bienvenue dans notre restaurant</h2>
            <h1 data-aos="fade-up" data-aos-delay="550">GOUTEZ UNE CUISINE ROYALE</h1>
            <div class="CTO">
                <a class="main-cta" style="margin-right: 50px;" href="#notre-carte" data-aos="fade-up"
                    data-aos-delay="600" data-aos-once="true">Voir la carte &nbsp;&nbsp;<i
                        class="fa-solid fa-arrow-right"></i></a>
                <a class="secondary-cta" href="./carte.php" data-aos="fade-up" data-aos-delay="750"
                    data-aos-once="true">Passer commande &nbsp;&nbsp;<i class="fa-solid fa-arrow-right"></i></a>
            </div>
        </div>
        <img style="position: absolute;" draggable="false" class="image-header" src="./image/homepage.webp"
            alt="Restoweb">

    </div>

    <div class="gradient"></div>
    <section class="content">
        <div class="cards">
            <div class="card" data-aos="fade-up" data-aos-delay="600">
                <img width="150px" draggable="false" src="./image/vegetables.png" alt="">
                <h2>PRODUITS FRAIS</h2>
                <p>Nous sélectionnons chaque jour des fruits et légumes de saison, cultivés localement pour garantir une
                    fraîcheur incomparable.</p>
            </div>
            <div class="card" data-aos="fade-up" data-aos-delay="750">
                <img width="150px" draggable="false" src="./image/restaurant.png" alt="">
                <h2>UN CHEF D'EXECELLENCE</h2>
                <p>Notre chef passionné élabore des plats savoureux en mêlant tradition et créativité pour ravir tous
                    les palais.</p>
            </div>
            <div class="card" data-aos="fade-up" data-aos-delay="900">
                <img width="150px" draggable="false" src="./image/value-proposition.png" alt="">
                <h2>RECETTES UNIQUES</h2>
                <p>Découvrez des recettes originales et exclusives, conçues pour surprendre vos papilles à chaque
                    bouchée.</p>
            </div>
        </div>

        <hr>

        <div class="notre-carte">
            <h1 id="notre-carte">Notre carte</h1>
            <h3 style="margin-bottom: 100px;">Découvrez nos produits phares.</h3>
            <div class="cards">
                <div class="card" data-aos="fade-up" data-aos-delay="900">
                    <img class="innershadow" draggable="false" width="300px" src="./image/entrecote.jpg" alt="">
                    <h2>ENTRECÔTE</h2>
                    <p>Une pièce de bœuf tendre et juteuse, grillée à la perfection, servie avec une sauce maison et
                        accompagnée de frites croustillantes ou de légumes de saison.</p>
                </div>
                <div class="card" data-aos="fade-up" data-aos-delay="750">
                    <img class="innershadow" draggable="false" width="300px" src="./image/cotedeboeuf.jpg" alt="">
                    <h2>CÔTE DE BŒUF</h2>
                    <p>Côte de bœuf maturée et cuite au feu de bois, relevée d’herbes aromatiques, idéale à partager
                        pour un moment convivial et gourmand.</p>
                </div>
                <div class="card" data-aos="fade-up" data-aos-delay="600">
                    <img class="innershadow" draggable="false" width="300px" src="./image/vivelaviande.jpg" alt="">
                    <h2>RECETTES VÉGÉTARIENNES</h2>
                    <p>Une sélection colorée et équilibrée de plats végétariens : curry de légumes, lasagnes aux
                        épinards ou encore salade de quinoa aux légumes grillés.</p>
                </div>
            </div>

            <a href="./carte.php" class="main-cta">Voir notre carte complète &nbsp;&nbsp;<i
                    class="fa-solid fa-arrow-right"></i></a>
        </div>


    </section>

</body>

</html>