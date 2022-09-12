<?php

namespace App\Service;

use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Produit;

class ProduitService
{
    public function __construct(private ManagerRegistry $doctrine)
    {
    }
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
}
