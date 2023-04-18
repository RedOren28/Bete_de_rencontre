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
            $annonce->setDatePublication(new \DateTime());
            $annonce->setDateModification(new \DateTime());
            $annonce->setUser($this->getUser());
            
            $entityManager->persist($annonce);
            $entityManager->flush();

            return $this->redirectToRoute('app_annonce', ['id' => $annonce->getId()]);
        }

        return $this->render('annonce/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/annonce/read/id/{id}', name: 'app_read_annonce')]
    public function index_id(Annonce $annonce): Response
    {
        return $this->render('annonce/id.html.twig', [
            'annonce' => $annonce
        ]);
    }

    #[Route('/annonce/{id}/edit', name: 'app_annonce_edit')]
    public function editAnnonce(Request $request, Annonce $annonce, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AnnonceType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_annonce', ['id' => $annonce->getId()]);
        }

        return $this->render('annonce/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/annonce/{id}/delete', name: 'app_annonce_delete')]
    public function deleteAnnonce(Annonce $annonce, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($annonce);
        $entityManager->flush();

        return $this->redirectToRoute('app_mes_annonces');
    }

    #[Route('/annonce/mes_annonces', name: 'app_mes_annonces')]
    public function mesAnnonces(AnnonceRepository $repository, Request $request): Response
    {
        $annonces = $repository->findBy(['user' => $this->getUser()]);

        return $this->render('annonce/mes_annonces.html.twig', [
            'annonces' => $annonces,
        ]);
    }
}

