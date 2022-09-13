<?php

namespace App\Service;

use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Produit;

class ProduitService
{
    public function __construct(private ManagerRegistry $doctrine)
    {
    }
    /*
        parametre : id du produit et quantité
        return : boolean si les stock sont suffisant
    */
    public function checkAskProduct($idProduct, $qty)
    {
        $productRepository = $this->doctrine->getRepository(Produit::class);
        $product = $productRepository->find($idProduct);
        if (!$product)
            return false;
        $qtyProduct = $product->getQuantity();
        if ($qtyProduct < $qty)
            return false;
        return true;
    }

    /*
        Parametre : tableau de requete en POST (quantité, id du produit , total)
        return : tableau avec l'entité produit et la quantité
    */
    public function getProductCommands($data)
    {
        $productRepository = $this->doctrine->getRepository(Produit::class);
        $nb = 0;
        $tab = [];
        if ($data && $data->get('total'))
            $nb = intval($data->get('total'));
        for ($i = 0; $i < $nb; $i++) {
            $quantity = $data->get('quantity_' . $i);
            $quantity = (intval($quantity)) ? intval($quantity) : 0;
            $idProduct = $data->get('id_' . $i);
            $product = $productRepository->find($idProduct);
            $obj = [
                "produit" => $product,
                "quantity" => $quantity
            ];
            $tab[] =  $obj;
        }
        return $tab;
    }
}
