<?php

namespace App\Service;

use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Panier;
use App\Entity\User;
use App\Entity\Produit;

class PanierService
{
    public function __construct(
        private ManagerRegistry $doctrine
    ) {
    }

    /*
        parametre : produit , id User, quantité
        return : le panier de l'utilisateur rempli
    */
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

    /*
        parametre : id User
        return : int le nombre de produit dans le panier d'un user
    */
    public function getNbProduitUser($userId)
    {
        $panierRepository = $this->doctrine->getRepository(Panier::class);
        $panierProductUser = $panierRepository->findBy(['idUser' => $userId]);
        $nb = count($panierProductUser);
        return $nb;
    }

    /*
        parametre : id User
        return : tableau formaté avec les produit du user dans le panier
    */
    public function getPanierUser($userId)
    {
        $panierRepository = $this->doctrine->getRepository(Panier::class);
        $produitRepository = $this->doctrine->getRepository(Produit::class);
        $panierUser = $panierRepository->findBy(['idUser' => $userId]);
        $tabProduit = [];
        if ($panierUser) {
            for ($i = 0; $i < count($panierUser); $i++) {
                $product = $produitRepository->findBy(['id' => $panierUser[$i]->getIdProduct()->getId()]);
                $product = $product[0];
                $obj = [
                    "quantity" => $panierUser[$i]->getQuantity(),
                    "quantityMax" => $product->getQuantity(),
                    "total" => $panierUser[$i]->getQuantity() * $product->getPrix(),
                    "label" =>  $product->getLabel(),
                    "price" => $product->getPrix(),
                    "img" => $product->getImage(),
                    "idProduct" => $product->getId()
                ];
                $tabProduit[] = $obj;
            }
        }
        return $tabProduit;
    }
}
