<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

#[
    Route('/admin'),
    IsGranted('ROLE_ADMIN')
]
class UserController extends AbstractController
{
    #[Route('/user/{page?1}/{nbr?12}', name: 'app_user')]
    public function index(ManagerRegistry $doctrine, $page, $nbr): Response
    {
        if (!(is_numeric($nbr) && is_numeric($page))) {
            return $this->redirectToRoute('app_admin');
        }
        $userRepository = $doctrine->getRepository(User::class);
        $nbPersonne = $userRepository->count([]);
        $nbPage = ceil($nbPersonne / $nbr);
        $users = $userRepository->findBy([], ['nom' => 'ASC'], $nbr, ($page - 1) * $nbr);
        return $this->render('user/index.html.twig', [
            'users' => $users,
            'isPaginated' => true,
            'nbPage' => $nbPage,
            'page' => $page,
            'nbr' => $nbr
        ]);
    }

    #[Route('/edit/user/{id?0}', name: 'app_user_edit')]
    public function editUser(ManagerRegistry $doctrine, Request $request, User $user = null): Response
    {
        if (!$user) {
            $this->addFlash('error', "Aucun utilisateur a été trouvé ");
            return $this->redirectToRoute('app_user');
        }


        $form = $this->createForm(UserType::class, $user);
        if (in_array("ROLE_ADMIN", $user->getRoles()))
            $form->get('administrateur')->setData(TRUE);
        else
            $form->get('administrateur')->setData(false);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('administrateur')->getData()) {
                $user->setRoles(["ROLE_ADMIN"]);
            } else {
                $user->setRoles([""]);
            }
            $manager = $doctrine->getManager();
            $manager->persist($user);
            $manager->flush();

            $this->addFlash('success', "L'utilisateur " . $user->getNom() . " " . $user->getPrenom() . " a été modifié ");
        }
        return $this->render('user/details.html.twig', [
            'user' => $form->createView(),
        ]);
    }

    #[Route('/delete/user/{id?0}', name: 'app_user_del')]
    public function delUser(ManagerRegistry $doctrine, User $user = null): Response
    {
        if ($user) {
            $this->addFlash('success', "L'utilisateur " . $user->getNom() . " " . $user->getPrenom() . " a été supprimé");
            $manager = $doctrine->getManager();
            $manager->remove($user);
            $manager->flush();
        } else {
            $this->addFlash('error', "L'utilisateur n'existe pas");
        }
        return $this->redirectToRoute('app_user');
    }
}
