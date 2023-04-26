<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OthersController extends AbstractController
{
    #[Route('/about', name: 'app_about')]
    public function index(): Response
    {
        return $this->render('others/about.html.twig');
    }

    #[Route('/accessibilite', name: 'app_accessibilite')]
    public function accessibilite(): Response
    {
        return $this->render('others/accessibilite.html.twig');
    }

    #[Route('/mentions', name: 'app_mentions')]
    public function mentions(): Response
    {
        return $this->render('others/mentions.html.twig');
    }
}
