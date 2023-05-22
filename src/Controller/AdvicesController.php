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

    #[Route('/advices/{category}/{animal}', name: 'app_advices_fiches')]
    public function fiches($category, $animal): Response
    {
        $template = 'advices/'.$category.'/'.$animal.'.html.twig';
        return $this->render($template);
    }
}
