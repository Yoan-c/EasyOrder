<?php

namespace App\Controller;

use App\Form\CategorieType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Entity\Categorie;

#[Route('/admin')]
class CategorieController extends AbstractController
{
    #[
        Route('/categories', name: 'app_admin_categorie'),
        IsGranted('ROLE_ADMIN')
    ]
    public function getAllCategorie(ManagerRegistry $doctrine): Response
    {
        $categorieRepository = $doctrine->getRepository(Categorie::class);
        $tabCategorie = $categorieRepository->findAll();

        //$this->addFlash("success", "Message reussi a passer avec succes");
        return $this->render('categorie/categorie.html.twig', [
            "tabCategorie" => $tabCategorie
        ]);
    }

    #[
        Route('/edit/categories/{id?0}', name: 'app_admin_categories_edit'),
        IsGranted('ROLE_ADMIN')
    ]
    public function editCategorie(
        ManagerRegistry $doctrine,
        Request $req,
        Categorie $categorie = null
    ): Response {

        $new = false;
        if (!$categorie) {
            $new = true;
            $categorie = new Categorie();
        }
        $form = $this->createForm(CategorieType::class, $categorie);
        // pre remplis le formulaire
        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $doctrine->getManager();
            $manager->persist($categorie);
            $manager->flush();

            $this->addFlash('success', $categorie->getNom() . " " . " a été ajouté ");
            return $this->redirectToRoute("app_admin_categorie");
        } else {
            //$this->addFlash("success", "Message reussi a passer avec succes");
            return $this->render('categorie/addCategorie.html.twig', [
                "formCategorie" => $form->createView(),
            ]);
        }
    }
    #[
        Route('/delete/categories/{id?0}', name: 'app_admin_categories_del'),
        IsGranted('ROLE_ADMIN')
    ]
    public function delCategorie(
        ManagerRegistry $doctrine,
        Request $req,
        Categorie $categorie = null
    ): Response {

        $new = false;
        if ($categorie) {
            $manager = $doctrine->getManager();
            $manager->remove($categorie);
            $manager->flush();
            $this->addFlash('success', $categorie->getNom() . " " . " a été supprimé ");
        } else {
            $this->addFlash('Error', "La catégorie n'a été supprimé ");
        }
        return $this->redirectToRoute("app_admin_categorie");
    }
}
