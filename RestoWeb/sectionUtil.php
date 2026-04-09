<?php
$title = "Utilisateur";
require_once("./function/db_function.php");
session_start();
$pdo = db_connect();

$sql = "SELECT * FROM commande WHERE idUtilisateur = :idUtil ORDER BY dateCommande DESC";
try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute([":idUtil" => $_SESSION['idUtilisateur']]);
    $userCommands = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $ex) {
    die("ERREUR lors de la requête: " . $ex->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php
    require_once('./inc/head.inc.php')
        ?>
    
    <style>
        .align {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);

            min-height: 150px;
        }
    </style>
</head>

<body>
    <?php
    require_once('./inc/nav.inc.php')
    ?>


    <div class="panier-container align">
        <h3>Historique de vos commande(s):</h3>
        <?php
        foreach ($userCommands as $userCommand) {
            ?>
            <div class="panier-container" style="width: 90%; position: relative; left: 50%; transform: translateX(-50%); padding-top: 20px;">
                Commandée le <?= $userCommand['dateCommande'] ?> - <?= $userCommand['totalCommande'] ?> €
            </div>
            <?php
        }
        ?>
    </div>
</body>