<?php

namespace App\Controller;

use App\Form\EditProfileType;
use App\Repository\AnnonceRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EditProfileController extends AbstractController
{
    #[Route('/edit/profile', name: 'app_edit_profile')]
    public function edit(AnnonceRepository $repository, Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(EditProfileType::class, $user);
        $annonces = $repository->findBy(['user' => $this->getUser()]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Your profile has been updated.');

            return $this->redirectToRoute('app_profile_edit');
        }

        return $this->render('edit_profile/profile.html.twig', [
            'form' => $form->createView(),
            'annonces' => $annonces,
        ]);
    }
}