<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Produit;
use App\Service\PanierService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Length;

class MainController extends AbstractController
{
    public function __construct(
        private PanierService $panierService
    ) {
    }
    #[Route('/', name: 'main')]
    public function appMain(): Response
    {

        return $this->redirectToRoute('app_main');
    }

    #[Route('/product/search/{page?1}/{nbr?12}', name: 'app_main_search')]
    public function getProductSearch(ManagerRegistry $doctrine, Request $req, $page, $nbr): Response
    {

        $categorieSearch = $req->query->get("categorie");
        $productSearch = $req->query->get("search");
        if (!$categorieSearch && !$productSearch) {
            return $this->redirectToRoute('app_main');
        }
        $isPaginated = true;
        $categorieSearch = "%" . $categorieSearch . "%";
        $productSearch = "%" . $productSearch . "%";
        $productRepository = $doctrine->getRepository(Produit::class);
        $products = $productRepository->searchProduct($categorieSearch, $productSearch);
        //  dd($test);
        $nbProduct = $productRepository->count([]);
        $nbPage = ceil($nbProduct / $nbr);
        $nbArticle = ($this->getUser()) ? $this->panierService->getNbProduitUser($this->getUser()->getId()) : 0;
        if (!$products || count($products) <= 0)
            $isPaginated = false;
        $categorieRepository = $doctrine->getRepository(Categorie::class);
        $categories = $categorieRepository->findAll();
        return $this->render('main/index.html.twig', [
            'produits' => $products,
            'categories' => $categories,
            'isPaginated' => $isPaginated,
            'nbPage' => $nbPage,
            'page' => $page,
            'nbr' => $nbr,
            "nbArticle" => $nbArticle
        ]);
    }
    #[Route('/product/{page?1}/{nbr?12}', name: 'app_main')]
    public function index(ManagerRegistry $doctrine, $page, $nbr): Response
    {
        $isPaginated = true;
        $productRepository = $doctrine->getRepository(Produit::class);
        $nbProduct = $productRepository->count([]);
        $nbPage = ceil($nbProduct / $nbr);
        $products = $productRepository->findBy([], [], $nbr, ($page - 1) * $nbr);
        $nbArticle = ($this->getUser()) ? $this->panierService->getNbProduitUser($this->getUser()->getId()) : 0;
        if (!$products || count($products) <= 0)
            $isPaginated = false;
        $categorieRepository = $doctrine->getRepository(Categorie::class);
        $categories = $categorieRepository->findAll();
        return $this->render('main/index.html.twig', [
            'produits' => $products,
            'categories' => $categories,
            'isPaginated' => $isPaginated,
            'nbPage' => $nbPage,
            'page' => $page,
            'nbr' => $nbr,
            "nbArticle" => $nbArticle
        ]);
    }
}
