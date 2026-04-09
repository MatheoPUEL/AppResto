<?php
require_once('../classes/panier.classes.php');
session_start();
require_once('db_function.php');
$dbh = db_connect();

if ( isset($_SESSION['panier']) && isset($_SESSION['emailUtilisateur']) && isset($_SESSION['idUtilisateur'])) {

    $CreateCommande = "INSERT INTO commande (dateCommande, totalCommande, typeCommande, idEtat, idUtilisateur)
                       VALUES (NOW(), :totalCommande, :typeCommande, :idEtat, :idUtilisateur)";
    $stmt = $dbh->prepare($CreateCommande);

    $total = 0;
    foreach ($_SESSION['panier'] as $produit) {
        $total += $produit->prix;
    }

    if ($_GET['choix'] == 0 ) {
      $_GET['choix'] = "SP";
    } else {
      $_GET['choix'] = "EMP";
    }
    $stmt->execute([
        ':totalCommande' => $total,
        ':typeCommande' => $_GET['choix'],
        ':idEtat' => 1,
        ':idUtilisateur' => $_SESSION['idUtilisateur']
    ]);

    $idCommande = $dbh->lastInsertId();

    $InsertLigne = "INSERT INTO ligne_commande (idCommande, idProduit, qteCommandee, prixHtLigneCommande)
                    VALUES (:idCommande, :idProduit, :quantite, :prix)";
    $stmtLigne = $dbh->prepare($InsertLigne);

    foreach ($_SESSION['panier'] as $produit) {
        $stmtLigne->execute([
            ':idCommande' => $idCommande,
            ':idProduit' => $produit->id,
            ':quantite' => $produit->quantite,
            ':prix' => $produit->prix
        ]);
    }
    $_SESSION['panier'] = null;
    header('Location: ../validation.php');

} else {
    header('Location: ../index.php');
}
?>
