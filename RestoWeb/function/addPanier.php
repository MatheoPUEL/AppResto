<?php
require_once('db_function.php');
require_once('../classes/panier.classes.php');
$pdo = db_connect();
session_start();

if (isset($_GET['idpro']) && isset($_SESSION['emailUtilisateur'])) {
    $produit = $pdo->prepare("SELECT * FROM produit WHERE idProduit = :idProduit");
    $produit->bindParam(":idProduit", $_GET["idpro"]);
    $produit->execute();
    $produit_data = $produit->fetch(PDO::FETCH_ASSOC);


    if (!isset($_SESSION['panier'])) {
        $_SESSION['panier'] = [];
    }

    $quantite = 1;
    $found= false;
    foreach ($_SESSION['panier'] as $item) {
        if ($item->id == $produit_data['idProduit']) {
          $item->quantite += 1;
          $found = true;
          header('Location: ../carte.php');
          exit;
      }
    }
    if($found == false) {
        $produit = new Panier($produit_data['idProduit'], $produit_data['libProduit'], $produit_data['descriptionProduit'], $produit_data['prixHtProduit'], $quantite);
        $_SESSION['panier'][] = $produit;
        header('Location: ../carte.php');
    }
} else {
    header('Localtion: ../index.php');
}
