<?php

namespace App\Controller;

use App\Form\EditProfileType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EditProfileController extends AbstractController
{
    #[Route('/edit/profile', name: 'app_edit_profile')]
    public function edit(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(EditProfileType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Your profile has been updated.');

            return $this->redirectToRoute('profile_edit');
        }

        return $this->render('edit_profile/profile.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}