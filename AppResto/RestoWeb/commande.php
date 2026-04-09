<?php
session_start();
require_once('./function/db_function.php');
$dbh = db_connect();
class Produit
{
    public $lib;
    public $quantite = 0;
    public $prix = 0;

    public $prix_ttc = 0;

    function setPrixTtc($quantite)
    {
        $this->prix_ttc = ($this->prix * $quantite) * 0.20;
    }
}


?>