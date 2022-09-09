<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Produit;
use App\Entity\User;
use App\Form\ProduitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\String\Slugger\SluggerInterface;
use App\Service\UploaderService;

#[Route('/admin')]
class AdminController extends AbstractController
{
    #[Route('/', name: 'app_admin')]
    public function index(): Response
    {
        $user = $this->getUser();
        $roles = $user->getRoles();
        if (!in_array("ROLE_ADMIN", $roles)) {
            return $this->redirectToRoute("app_main");
        }


        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    #[
        Route('/produits', name: 'app_admin_products'),
        IsGranted('ROLE_ADMIN')
    ]
    public function getAllProduct(ManagerRegistry $doctrine): Response
    {
        $productRepository = $doctrine->getRepository(Produit::class);
        $tabProduits = $productRepository->findAll();

        //$this->addFlash("success", "Message reussi a passer avec succes");
        return $this->render('admin/produit.html.twig', [
            'test' => 'AdminController',
            "tabProduits" => $tabProduits
        ]);
    }
    #[
        Route('/edit/produits/{id?0}', name: 'app_admin_products_edit'),
        IsGranted('ROLE_ADMIN')
    ]
    public function editProduct(
        ManagerRegistry $doctrine,
        Request $req,
        UploaderService $uploader,
        Produit $produit = null
    ): Response {

        $new = false;
        if (!$produit) {
            $new = true;
            $produit = new Produit();
        }
        $form = $this->createForm(ProduitType::class, $produit);
        // pre remplis le formulaire
        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()) {

            $image = $form->get('image')->getData();
            if ($image) {
                $directory = $this->getParameter('produits_directory');
                $produit->setImage($uploader->uploadFile($image, $directory));
            }

            $manager = $doctrine->getManager();
            $manager->persist($produit);
            $manager->flush();

            $this->addFlash('success', $produit->getLabel() . " " . " a été ajouté ");
            return $this->redirectToRoute("app_admin_products");
        } else {
            //$this->addFlash("success", "Message reussi a passer avec succes");
            return $this->render('admin/addProduit.html.twig', [
                "formProduct" => $form->createView()
            ]);
        }
    }
}
