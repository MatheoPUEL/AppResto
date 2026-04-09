<?php
$title = "Inscription";
require_once('./function/db_function.php');
$dbh = db_connect();

$login = "";
$prenom = "";
$email = "";
$password = "";
$repeatpassword = "";

//commandes sql
$sqlinsert = ("INSERT INTO utilisateur(loginUtilisateur,prenomUtil,emailUtilisateur,mdpUtilisateur) VALUES (:login,:prenom,:email,:password)");
$sqlcheck = ("SELECT COUNT(*) FROM utilisateur WHERE emailUtilisateur = :email");

//si toutes les variables sont remplies on continue
if (isset($_POST["login"]) && isset($_POST["prenom"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["repeatpassword"])) {
    $login = htmlspecialchars(trim($_POST["login"]));
    $prenom = htmlspecialchars(trim($_POST["prenom"]));
    $email = htmlspecialchars(trim($_POST["email"]));
    $password = htmlspecialchars($_POST["password"]);
    $repeatpassword = htmlspecialchars(trim($_POST["repeatpassword"]));

    $sthcheck = $dbh->prepare($sqlcheck);
    $sthcheck->execute([":email" => $email]);
    $emailexists = $sthcheck->fetchColumn();

    if ($emailexists > 0) {
        $messager_email = "Cet email est déjà inscrit";
        echo $messager_email;
    } else {
        if (strlen($password) >= 8) {
            if ($password == $repeatpassword) {
                $password = password_hash($password, PASSWORD_DEFAULT);
                try {
                    $sthinsert = $dbh->prepare($sqlinsert);
                    $sthinsert->execute(array(":login" => $login, ":prenom" => $prenom, ":email" => $email, ":password" => $password, ));
                    $messagev = "Inscription prise en compte !";
                    echo $messagev;
                } catch (PDOException) {
                    $messager_mdp = "Erreur lors de l'inscription, veuillez réessayer plus tard : ";
                    echo $messager_mdp;
                }
            } else {
                $messager_mdp = "Les mots de passe ne correspondent pas";
                echo $messager_mdp;
            }
        } else {
            $messager_str = "Le mot de passe doit être supérieur à 8 caractères";
            echo $messager_str;
        }
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
<form method="post" action="" class="auth">
    <h1>Connexion</h1>
    <?php
    if (isset($messager_mdp)) {
        ?>
        <div class="alert-danger">
            <?= $messager_mdp ?>
        </div>
        <?php
    }
    if (isset($messagev)) {
        ?>
        <div class="alert-danger">
            <?= $messagev ?>
        </div>
        <?php
    }
    ?>
    <input name="login" type="text" placeholder="Nom" name="">
    <input name="prenom" type="text" placeholder="Prenom" name="">
    <input name="email" type="email" placeholder="Email" name="">
    <input name="password" type="password" placeholder="Mot de passe">
    <input name="repeatpassword" type="password" placeholder="Répetez le Mot de passe">
    <input type="submit">
</form>

<body>
    <?php
    require_once('./inc/nav.inc.php')
        ?>
</body>