<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Form\AnnonceType;
use App\Repository\AnnonceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AnnonceController extends AbstractController
{
    #[Route('/annonce', name: 'app_annonce')]
    public function index(AnnonceRepository $repository, Request $request): Response
    {
        $annonces = $repository->findAll();

        return $this->render('annonce/index.html.twig', [
            'controller_name' => 'AnnonceController',
            'annonces' => $annonces,
        ]);
    }

    #[Route('/annonce/create', name: 'app_annonce_create')]
    public function createAnnonce(Request $request, EntityManagerInterface $entityManager): Response
    {
        $annonce = new Annonce();
        $form = $this->createForm(AnnonceType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $annonce->setCreatedAt(new \DateTime());
            $annonce->setUser($this->getUser());
            
            $entityManager->persist($annonce);
            $entityManager->flush();

            return $this->redirectToRoute('app_annonce', ['id' => $annonce->getId()]);
        }

        return $this->render('annonce/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}


