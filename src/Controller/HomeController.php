<?php

namespace App\Controller;

use App\Repository\AnnonceRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(AnnonceRepository $repository, Request $request): Response
    {
        $annonces = $repository->findBy([], ['date_publication' => 'DESC'], 12);

        return $this->render('home/index.html.twig', [
            'annonces' => $annonces,
        ]);
    }
}