<?php

namespace App\Controller;

use App\Form\EditProfileType;
use App\Repository\AnnonceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EditProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function edit(AnnonceRepository $repository, Request $request, EntityManagerInterface $entityManager)
    {
        $user = $this->getUser();
        $form = $this->createForm(EditProfileType::class, $user);
        $annonces = $repository->findBy(['user' => $this->getUser()]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Your profile has been updated.');

            return $this->redirectToRoute('app_profile');
        }

        return $this->render('profile/index.html.twig', [
            'form' => $form->createView(),
            'annonces' => $annonces,
        ]);
    }
}