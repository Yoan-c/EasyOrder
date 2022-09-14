<?php

namespace App\Controller;

use App\Entity\User;

use App\Form\UserType;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[

    Route('/compte'),
    IsGranted('ROLE_USER')
]
class CompteController extends AbstractController
{
    #[Route('/', name: 'app_compte')]
    public function index(ManagerRegistry $doctrine, Request $request): Response
    {
        $userRepo = $doctrine->getRepository(User::class);
        $user = $userRepo->find($this->getUser()->getId());
        $form = $this->createForm(UserType::class, $user);
        $form->remove("email");
        $form->remove("administrateur");
        $form->handleRequest($request);
        //dd($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $manager = $doctrine->getManager();
            $manager->persist($user);
            $manager->flush();
            $this->addFlash('success', "Les informations de votre compte ont bien été modifié ");
        }

        return $this->render('compte/index.html.twig', [
            'formUser' => $form->createView(),
        ]);
    }

    #[Route('/edit/pass', name: 'app_compte_edit_pass')]
    public function changePass(
        UserPasswordHasherInterface $userPasswordHasher,
        ManagerRegistry $doctrine,
        Request $request
    ): Response {
        $pass = $request->request->get('pass');
        $confirmPass = $request->request->get('confirmPass');
        $bool = false;
        if ($pass < 6) {
            $this->addFlash("error", "Le mot de passe doit contenir au minimum 6 caractères");
        } else if ($pass !== $confirmPass) {
            $this->addFlash("error", "Les mot de passe doivent être identique");
        } else {
            $bool = true;
        }
        if (!$bool)
            return $this->redirectToRoute("app_compte");

        $userRepo = $doctrine->getRepository(User::class);
        $user = $userRepo->find($this->getUser()->getId());

        $user->setPassword(
            $userPasswordHasher->hashPassword(
                $user,
                $pass
            )
        );
        $manager = $doctrine->getManager();
        $manager->persist($user);
        $manager->flush();
        $this->addFlash('success', "Votre mot de passe a bien été modifié ");

        return $this->redirectToRoute("app_compte");
    }
}
