<?php
$title = "Notre carte";

require_once('./function/db_function.php');
require_once('./classes/panier.classes.php');
session_start();

$dbh = db_connect();

// Récupérer tous les types
$sql = "SELECT * FROM type";

try {
    $sth = $dbh->prepare($sql);
    $sth->execute();
    $types = $sth->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $ex) {
    die("Erreur lors de la requête sql de récupération des types : " . $ex->getMessage());
}

// Pour chaque type, récupérer les produits associés
$produitsByType = [];
foreach ($types as $type) {
    $sql = "SELECT * FROM produit WHERE idType = ?";
    
    try {
        $sth = $dbh->prepare($sql);
        $sth->execute([$type['idType']]);
        $produits = $sth->fetchAll(PDO::FETCH_ASSOC);
        
        if (!empty($produits)) {
            $produitsByType[$type['idType']] = [
                'libType' => $type['libType'],
                'produits' => $produits
            ];
        }
    } catch (PDOException $ex) {
        die("Erreur lors de la requête sql de récupération des produits : " . $ex->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <?php require_once('./inc/head.inc.php') ?>
</head>

<body>
    <?php require_once('./inc/nav.inc.php') ?>

    <section class="content-2">
        <div class="notre-carte">
            <h1 id="notre-carte">Notre carte</h1>
            <h3 style="margin-bottom: 100px;">Découvrez tous nos produits.</h3>
            <div style="display: flex; flex-direction: row; gap: 25px;">
                <div style="position: relative; width: 70%;">

                    <!-- Affichage dynamique des catégories -->
                    <?php foreach ($produitsByType as $idType => $typeData): ?>
                        <button type="button" class="collapsible"><?= htmlspecialchars($typeData['libType']) ?></button>
                        <div class="collapse-content">
                            <?php foreach ($typeData['produits'] as $produit): ?>
                                <div class="card-product">
                                    <div class="card-product-text">
                                        <p style="font-size: 25px;"><?= htmlspecialchars($produit["libProduit"]) ?></p>
                                        <p><?= htmlspecialchars($produit["descriptionProduit"]) ?></p>
                                        <p><?= number_format($produit["prixHtProduit"], 2, ',', ' ') ?> €</p>
                                    </div>
                                    <div class="card-product-cta">
                                        <a href="./function/addPanier.php?idpro=<?= urlencode($produit["idProduit"]) ?>">
                                            Ajouter au panier &nbsp;&nbsp;<i class="fa-solid fa-plus"></i>
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                </div>


                <form action="paiement.php" method="POST" style="width: 25%; padding: 15px;">
                    <h3>Votre panier:</h3>
                    <?php
                    if (isset($_SESSION['panier'])) {
                        $items = (array) $_SESSION['panier'];
                    ?>
                        <ul style="text-align: left;">
                            <?php
                            for ($i = 0; $i < count($items); $i++) {
                            ?>
                                <li>x<?= $items[$i]->quantite ?> - <?= htmlspecialchars($items[$i]->lib) ?> - <a
                                        href="./function/removeItemPanier.php?idpro=<?= $items[$i]->id ?>"><i
                                            style="color: white;" class="fa-solid fa-trash"></i></a></li>
                            <?php
                            }
                            ?>
                        </ul>
                        <?php
                        if (!empty($_SESSION['panier'])) {
                            $total = Panier::calculerPrixTotal($_SESSION['panier']);
                            echo "<p>Prix total du panier : " . number_format($total, 2, ',', ' ') . " € </p>";
                        } else {
                            echo "Votre panier est vide.";
                        }
                        ?>
                    <?php
                    } else {
                        echo '<p>Votre panier est vide</p>';
                    }
                    ?>
                    <div style="display: flex; justify-content: center; align-items: center;">
                        <input type="radio" id="contactChoice1" name="choix" value="0" checked />
                        <label for="contactChoice1">Sur place</label>

                        <input type="radio" id="contactChoice2" name="choix" value="1" />
                        <label for="contactChoice2">Emporter</label>
                    </div>
                    <button type="submit" class="btn-paiment" id="complete-payment">Passer au paiement</button>
                </form>
            </div>

        </div>
    </section>


    <script>
        var coll = document.getElementsByClassName("collapsible");
        var i;

        for (i = 0; i < coll.length; i++) {
            coll[i].addEventListener("click", function() {
                this.classList.toggle("active");
                var content = this.nextElementSibling;
                if (content.style.display === "block") {
                    content.style.display = "none";
                } else {
                    content.style.display = "block";
                }
            });
        }
    </script>
</body>

</html>