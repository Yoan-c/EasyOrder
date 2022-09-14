<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\CommandeProduit;
use App\Entity\Panier;
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
    Route('/order'),
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

    #[Route('/', name: 'app_commande')]
    public function index(): Response
    {
        $commandeRepo = $this->doctrine->getRepository(Commande::class);
        $commandes = $commandeRepo->findAll();
        return $this->render('commande/index.html.twig', [
            'commandes' => $commandes
        ]);
    }
    #[Route('/detail/{id?0}', name: 'app_commande_detail')]
    public function detailCommande(Commande $commande = null): Response
    {
        if (!$commande) {
            $this->addFlash('error', "Une erreur s'est produite");
            // rediriger vers l'acceuil du compte
            return $this->redirectToRoute('app_commande');
        }
        $commandeRepo = $this->doctrine->getRepository(CommandeProduit::class);
        $commandes = $commandeRepo->findBy(["idCommande" => $commande->getId()]);
        $productRepo = $this->doctrine->getRepository(Produit::class);

        $tab = [];
        $tab[] = [
            "idCommande" => $commande->getId(),
            "date" => $commande->getDate(),
            "total" => $commande->getTotal()
        ];

        for ($i = 0; $i < count($commandes); $i++) {
            $product = $productRepo->find($commandes[$i]->getIdProduit()->getId());
            $obj = [
                "quantity" => $commandes[$i]->getQuantity(),
                "totalProduit" => $commandes[$i]->getTotal(),
                "prix" => $product->getPrix(),
                "label" => $product->getLabel(),
                "image" => $product->getImage(),
            ];
            $tab[] = $obj;
        }

        return $this->render('commande/detail.html.twig', [
            "commandes" => $tab
        ]);
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
        $totalCommande = 0;
        $commande = new Commande();
        $commande->setDate(new DateTime('now'));
        $commande->setUser($user);
        $commande->setTotal($totalCommande);
        $manager->persist($commande);
        // faire un persist

        for ($i = 0; $i < count($tabProduct); $i++) {

            $commandeProduit = new CommandeProduit();
            $commandeProduit->setIdCommande($commande);
            $commandeProduit->setIdProduit($tabProduct[$i]["produit"]);
            $qty = ($tabProduct[$i]["quantity"] > $tabProduct[$i]["produit"]->getQuantity()) ? $tabProduct[$i]["produit"]->getQuantity() : $tabProduct[$i]["quantity"];
            $commandeProduit->setQuantity($qty);
            $totalCommande += $qty * $tabProduct[$i]["produit"]->getPrix();
            $commandeProduit->setTotal($qty * $tabProduct[$i]["produit"]->getPrix());
            $productRepositoy = $this->doctrine->getRepository(Produit::class);
            $product = $productRepositoy->find($tabProduct[$i]["produit"]->getId());
            $product->setQuantity($product->getQuantity() - $qty);
            $manager->persist($commandeProduit);
            $manager->persist($product);
            $manager->flush();
        }
        $commande->setTotal($totalCommande);
        $manager->persist($commande);
        $panierRepo = $this->doctrine->getRepository(Panier::class);
        $panierUser = $panierRepo->findBy(["idUser" => $user->getId()]);
        for ($i = 0; $i < count($panierUser); $i++) {
            $manager->remove($panierUser[$i]);
        }
        $manager->flush();
        $this->addFlash("success", "La commande a bien été enregistré");
        return $this->redirectToRoute('app_main');
    }
}
