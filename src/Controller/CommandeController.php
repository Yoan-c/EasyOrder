<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\CommandeProduit;
use App\Entity\Produit;
use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\ProduitService;
use App\Service\PanierService;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;

#[
    Route('/commande'),
    IsGranted('ROLE_USER')
]
class CommandeController extends AbstractController
{
    public function __construct(
        private ProduitService $productService,
        private PanierService $panierService,
        private ManagerRegistry $doctrine,
    ) {
    }
    #[Route('/add', name: 'app_commande_add')]
    public function addCommande(Request $req): Response
    {
        if (!$this->getUser())
            return $this->redirectToRoute('app_main');
        $data = $req->request;
        $tabProduct = $this->productService->getProductCommands($data);
        if (!$tabProduct) {
            $this->addFlash('error', "Une erreur est survenu dans la commande, si le problème persiste, veuillez nous contacter");
            return $this->redirectToRoute("app_main");
        }

        $manager = $this->doctrine->getManager();
        $userRepositoy = $this->doctrine->getRepository(User::class);
        $user = $userRepositoy->find($this->getUser()->getId());

        $commande = new Commande();
        $commande->setDate(new DateTime('now'));
        $commande->setUser($user);
        $manager->persist($commande);
        // faire un persist

        for ($i = 0; $i < count($tabProduct); $i++) {
            $commandeProduit = new CommandeProduit();
            $commandeProduit->setIdCommande($commande);
            $commandeProduit->setIdProduit($tabProduct[$i]["produit"]);
            $qty = ($tabProduct[$i]["quantity"] > $tabProduct[$i]["produit"]->getQuantity()) ? $tabProduct[$i]["produit"]->getQuantity() : $tabProduct[$i]["quantity"];
            $commandeProduit->setQuantity($qty);
            $commandeProduit->setTotal($qty * $tabProduct[$i]["produit"]->getPrix());
            $productRepositoy = $this->doctrine->getRepository(Produit::class);
            $product = $productRepositoy->find($tabProduct[$i]["produit"]->getId());
            $product->setQuantity($product->getQuantity() - $qty);
            $manager->persist($commandeProduit);
            $manager->persist($product);
            $manager->flush();
        }
        // $manager->flush();
        $this->addFlash("success", "La commande a bien été enregistré");
        return $this->redirectToRoute('app_main');
    }
}
