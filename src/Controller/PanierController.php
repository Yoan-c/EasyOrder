<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/panier')]
class PanierController extends AbstractController
{
    #[Route('/add', name: 'app_panier_add')]
    public function index(): Response
    {
        $verified = null;
        if (!$this->getUser()->isVerified()) {
            $this->addFlash('error', "Vous devez vérifier votre compte avant de pouvoir mettre un article dans le panier");
            return $this->redirectToRoute("app_main");
        }

        // traitement pour mettre dans le panier
        return $this->render('panier/index.html.twig', [
            'controller_name' => 'PanierController',
        ]);
    }
}
