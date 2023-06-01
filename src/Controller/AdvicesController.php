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
        // Page d'index des conseils template 'advices/index.html.twig'
        return $this->render('advices/index.html.twig');
    }

    #[Route('/advices/{category}/{animal}', name: 'app_advices_fiches')]
    public function fiches($category, $animal): Response
    {
        // Affiche une fiche de conseil spécifique le template est construit à partir des valeurs de $category et $animal
        $template = 'advices/'.$category.'/'.$animal.'.html.twig';
        return $this->render($template);
    }
}
