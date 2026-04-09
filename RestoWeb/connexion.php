<?php
$title = "Connexion";
require_once("./function/db_function.php");
session_start();
$pdo = db_connect();

if (isset($_POST["login"]) && isset($_POST["password"])) {
    $login = $_POST["login"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM utilisateur WHERE emailUtilisateur = :emailUtilisateur";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([":emailUtilisateur" => $login]);
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $ex) {
        die("ERREUR lors de la requête: " . $ex->getMessage());
    }


    // Vérifier si l'utilisateur existe et vérifier le mot de passe
    if ($userData && password_verify($password, $userData['mdpUtilisateur'])) {
        $_SESSION['emailUtilisateur'] = $userData['emailUtilisateur'];
        $_SESSION['loginUtilisateur'] = $userData['loginUtilisateur'];
        $_SESSION['prenomUtilisateur'] = $userData['prenomUtil'];
        $_SESSION['idUtilisateur'] = $userData['idUtilisateur'];
        header('Location: index.php');
        exit();
    } else {
        $message = 'Identifiant ou mot de passe incorrect';
    }
}
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

    <form method="post" action="" class="auth" novalidate>
        <h1>Connexion</h1>
        <?php
        if (isset($message)) {
            ?>
            <div class="alert-danger">
                <?= $message ?>
            </div>
            <?php
        }
        ?>
        <input required name="login" type="email" placeholder="Email" name="">
        <input required name="password" type="password" placeholder="Mot de passe">
        <input type="submit">
    </form>
</body>