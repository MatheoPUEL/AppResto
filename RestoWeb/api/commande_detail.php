<?php
    require_once('../function/db_function.php');

    $dbh = db_connect();
    $id = $_GET['id_commande'];

    $sql = "SELECT p.libProduit, lc.qteCommandee, lc.prixHtLigneCommande
            FROM ligne_commande lc
            JOIN produit p ON lc.idProduit = p.idProduit
            WHERE lc.idCommande = :id";

    $sth = $dbh->prepare($sql);
    $sth->execute([':id' => $id]);
    $lignes = $sth->fetchAll(PDO::FETCH_ASSOC);

    $tableau = [];
    foreach ($lignes as $ligne) {
        $tableau[] = [
            "libProduit"          => $ligne['libProduit'],
            "qteCommandee"        => $ligne['qteCommandee'],
            "prixHtLigneCommande" => $ligne['prixHtLigneCommande']
        ];
    }

    echo json_encode($tableau);
?>
