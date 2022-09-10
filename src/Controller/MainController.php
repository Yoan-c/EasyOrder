<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Produit;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(ManagerRegistry $doctrine): Response
    {

        $productRepository = $doctrine->getRepository(Produit::class);
        $products = $productRepository->findAll();
        $categorieRepository = $doctrine->getRepository(Categorie::class);
        $categories = $categorieRepository->findAll();
        return $this->render('main/index.html.twig', [
            'produits' => $products,
            'categories' => $categories
        ]);
    }
}
