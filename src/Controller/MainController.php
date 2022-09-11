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
    #[Route('/', name: 'main')]
    public function appMain(): Response
    {

        return $this->redirectToRoute('app_main');
    }
    #[Route('/product/{page?1}/{nbr?12}', name: 'app_main')]
    public function index(ManagerRegistry $doctrine, $page, $nbr): Response
    {
        $productRepository = $doctrine->getRepository(Produit::class);
        $nbProduct = $productRepository->count([]);
        $nbPage = ceil($nbProduct / $nbr);
        $products = $productRepository->findBy([], [], $nbr, ($page - 1) * $nbr);
        $categorieRepository = $doctrine->getRepository(Categorie::class);
        $categories = $categorieRepository->findAll();
        return $this->render('main/index.html.twig', [
            'produits' => $products,
            'categories' => $categories,
            'isPaginated' => true,
            'nbPage' => $nbPage,
            'page' => $page,
            'nbr' => $nbr
        ]);
    }
}
