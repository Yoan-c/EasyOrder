<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

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
    public function getAllProduct(): Response
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
}
