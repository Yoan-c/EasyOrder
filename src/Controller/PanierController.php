<?php

namespace App\Controller;

use App\Service\ProduitService;
use App\Service\PanierService;
use App\Entity\Produit;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/panier')]
class PanierController extends AbstractController
{
    public function __construct(
        private ProduitService $productService,
        private PanierService $panierService,
        private ManagerRegistry $doctrine,

    ) {
    }
    #[Route('/', name: 'app_panier')]
    public function showPanier(): Response
    {
        if (!$this->getUser()) {
            $this->addFlash('error', "Veuillez vous connecter");
            return $this->redirectToRoute('app_main');
        }
        $paniers =  $this->panierService->getPanierUser($this->getUser());
        return $this->render('panier/index.html.twig', [
            'paniers' => $paniers
        ]);
    }

    #[Route('/add/{idProduct?0}/{qty?1}/{page?1}', name: 'app_panier_add')]
    public function index($idProduct, $qty, $page): Response
    {
        if (!(is_numeric($idProduct) && is_numeric($qty) && is_numeric($page))) {
            return $this->redirectToRoute('app_main');
        }
        if (!($this->getUser())) {
            $this->addFlash("error", "veuillez vous connecter pour acceder à cette page");
            return $this->redirectToRoute("app_main");
        }
        if (!($idProduct > 0 && $qty > 0)) {
            $this->addFlash("error", "Une erreur est survenu vérifier la quantité et le produit que vous souhitez mettre dans le panier");
            return $this->redirectToRoute("app_main");
        }
        if (!$this->getUser()->isVerified()) {
            $this->addFlash('error', "Vous devez vérifier votre compte avant de pouvoir mettre un article dans le panier");
            return $this->redirectToRoute("app_main");
        }
        if (!$this->productService->checkAskProduct($idProduct, $qty)) {
            $this->addFlash('error', "les stocks sont insuffisants ");
            return $this->redirectToRoute("app_main");
        }
        $productRepository = $this->doctrine->getRepository(Produit::class);
        $product = $productRepository->find($idProduct);
        $panier =  $this->panierService->addPanierUser($product, $this->getUser()->getId(), $qty);
        $manager = $this->doctrine->getManager();
        $this->getUser()->addPanier($panier);
        $manager->persist($this->getUser());
        $manager->flush();
        $this->addFlash('success', "l'article " . $product->getLabel() . " a bien été ajouté à votre panier");
        return $this->redirectToRoute('app_main', [
            'page' => $page,
            'nbr' => "12"
        ]);
    }
}
