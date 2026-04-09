<?php
require_once("../function/db_function.php");
$id = $_GET['id_commande'];
$dbh = db_connect();
$sql = "UPDATE commande SET  idEtat = 3 WHERE idCommande = " . $id;
$stmt = $dbh->prepare($sql);
$stmt->execute();
