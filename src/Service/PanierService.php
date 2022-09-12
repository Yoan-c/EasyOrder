<?php

namespace App\Service;

use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Panier;
use App\Entity\User;

class PanierService
{
    public function __construct(
        private ManagerRegistry $doctrine
    ) {
    }

    public function addPanierUser($product, $userId, $qty)
    {
        $panierRepository = $this->doctrine->getRepository(Panier::class);
        $panierProductUser = $panierRepository->findBy(['idUser' => $userId, 'idProduct' => $product->getId()]);
        $userRepository = $this->doctrine->getRepository(User::class);
        $user = $userRepository->find($userId);
        if (count($panierProductUser) == 0) {
            $panier = new Panier();
        } else {
            $panier = $panierProductUser[0];
        }
        $panier->setQuantity($panier->getQuantity() + $qty);
        $panier->setIdProduct($product);
        $manager = $this->doctrine->getManager();
        $manager->persist($panier);
        return $panier;
    }

    public function getNbProduitUser($userId)
    {
        $panierRepository = $this->doctrine->getRepository(Panier::class);
        $panierProductUser = $panierRepository->findBy(['idUser' => $userId]);
        $nb = count($panierProductUser);
        return $nb;
    }
}
