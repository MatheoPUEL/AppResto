<?php
    require_once('../function/db_function.php');

    $dbh = db_connect();

    $sql = "SELECT 
                commande.idCommande, 
                commande.dateCommande, 
                etat.libEtat, 
                commande.totalCommande,
                COUNT(ligne_commande.idProduit) AS nbProduits
            FROM commande 
            JOIN utilisateur 
                ON commande.idUtilisateur = utilisateur.idUtilisateur 
            JOIN etat 
                ON commande.idEtat = etat.idEtat 
            JOIN ligne_commande 
                ON ligne_commande.idCommande = commande.idCommande 
            GROUP BY 
                commande.idCommande, 
                commande.dateCommande, 
                etat.libEtat, 
                commande.totalCommande";
    
    $tableau = [];
   
    $sth = $dbh->prepare($sql);
    $sth->execute();
    $commandes = $sth->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($commandes as $commande) {
        $tableau[] = [
            "id" => $commande['idCommande'],
            "date" => $commande['dateCommande'],
            "prix" => $commande['totalCommande'],
            "etat" => $commande['libEtat'],
            "nbProduits" => $commande['nbProduits']
        ];
    }

    $json = json_encode($tableau);
    echo $json;
?>