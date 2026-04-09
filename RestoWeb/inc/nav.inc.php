    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    <nav>
        <div class="user-section" style="width: 40%;">
            <img height="150px" src="./image/logo.png" alt="logo" data-aos="fade-left" data-aos-delay="150">
            <a href="./index.php" data-aos="fade-left" data-aos-delay="300">Accueil</a>
            <a href="" data-aos="fade-left" data-aos-delay="450">En savoir plus</a>
            <a href="./carte.php" data-aos="fade-left" data-aos-delay="500">Notre carte</a>
        </div>
        <div class="user-section">
            <?php
            if(isset($_SESSION['loginUtilisateur'])) {
                ?>
                <a href="./sectionUtil.php" class="nav-name" data-aos="fade-left" data-aos-delay="600">Historique</a>
                <a href="./carte.php" data-aos="fade-left" data-aos-delay="750">Voir mon panier &nbsp;&nbsp;<img height="20px" src="./image/shopping-cart.png" alt=""></a>
                <a href="./deconnexion.php" data-aos="fade-left" data-aos-delay="750">Se deconnecter &nbsp;&nbsp;<i class="fa-solid fa-right-from-bracket"></i></a>

                <?php
            } else {
                ?>
                <a href="./connexion.php" data-aos="fade-left" data-aos-delay="600">Se connecter</a>
                <a href="./inscription.php" data-aos="fade-left" data-aos-delay="750">S'inscrire</a>
                <?php
            }
            ?>
        </div>
    </nav>