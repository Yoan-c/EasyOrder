<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Service\UploaderService;

#[Route('/admin')]
class ProduitController extends AbstractController
{
    #[Route('/', name: 'app_admin')]
    public function index(): Response
    {
        $user = $this->getUser();
        $roles = $user->getRoles();
        if (!in_array("ROLE_ADMIN", $roles)) {
            return $this->redirectToRoute("app_main");
        }


        return $this->render('produit/index.html.twig', [
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
        return $this->render('produit/produit.html.twig', [
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
        $linkImage = $produit->getImage();
        if ($form->isSubmitted() && $form->isValid()) {

            $image = $form->get('image')->getData();
            if ($image) {
                $directory = $this->getParameter('produits_directory');
                $produit->setImage($uploader->uploadFile($image, $directory, $produit->getImage()));
            }

            $manager = $doctrine->getManager();
            $manager->persist($produit);
            $manager->flush();

            $this->addFlash('success', $produit->getLabel() . " " . " a été ajouté ");
            return $this->redirectToRoute("app_admin_products");
        } else {
            //$this->addFlash("success", "Message reussi a passer avec succes");
            return $this->render('produit/addProduit.html.twig', [
                "formProduct" => $form->createView(),
                "produitImg" => $linkImage
            ]);
        }
    }
    #[
        Route('/delete/produits/{id?0}', name: 'app_admin_products_del'),
        IsGranted('ROLE_ADMIN')
    ]
    public function deleteProduct(
        ManagerRegistry $doctrine,
        Produit $produit = null
    ): Response {

        if ($produit) {
            $manager = $doctrine->getManager();
            $manager->remove($produit);
            $manager->flush();
            $this->addFlash('success', $produit->getLabel() . " " . " a été supprimé ");
        } else {
            $this->addFlash('Error', "Le produit n'a été supprimé ");
        }
        return $this->redirectToRoute("app_admin");
    }
}