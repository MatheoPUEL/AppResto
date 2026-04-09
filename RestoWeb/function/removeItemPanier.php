<?php
require_once('../classes/panier.classes.php');
session_start();

if (isset($_GET['idpro']) && isset($_SESSION['panier'])) {
    $id = $_GET['idpro'];
    $trouve = false;
    
    $_SESSION['panier'] = array_filter($_SESSION['panier'], function($produit) use ($id, &$trouve) {
        if (!$trouve && $produit->id == $id) {
            $trouve = true;
            return false;
        }
        return true;
    });
    
    $_SESSION['panier'] = array_values($_SESSION['panier']);
    
    header('Location: ../carte.php');
    exit();
} else {
    header('Location: ../connexion.php');
    exit();
}