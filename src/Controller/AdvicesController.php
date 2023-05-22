<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdvicesController extends AbstractController
{
    #[Route('/advices', name: 'app_advices')]
    public function index(): Response
    {
        return $this->render('advices/index.html.twig');
    }
}
