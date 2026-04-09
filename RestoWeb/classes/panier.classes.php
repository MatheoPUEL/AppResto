<?php

class Panier
{
    public $id;
    public $lib;
    public $description;
    public $prix;
    public $quantite;
    public static $prixTotal;

    function __construct($id, $lib, $description, $prix, $quantite)
    {
        $this->id = $id;
        $this->lib = $lib;
        $this->description = $description;
        $this->prix = $prix;
        $this->quantite = $quantite;
    }

    public static function calculerPrixTotal($panier)
    {
        $total = 0.0;
        foreach ($panier as $produit) {
            $total += $produit->prix * $produit->quantite;
        }
        self::$prixTotal = $total;
        return $total;
    }
}
