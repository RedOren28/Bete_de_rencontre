<?php

namespace App\Controller;

use Throwable;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ErrorController extends AbstractController
{
    public function showException(Throwable $exception)
    {
        $statusCode = $exception instanceof HttpExceptionInterface ? $exception->getStatusCode() : 500;

        if ($statusCode === 404) {
            $template = 'error/' . $statusCode . '.html.twig';

            $content = $exception->getMessage();

            return new Response(
                $this->container->get('twig')->render(
                    $template,
                    ['exception' => FlattenException::create($exception), 'status_code' => $statusCode, 'status_text' => Response::$statusTexts[$statusCode], 'content' => $content]
                ),
                $statusCode
            );
        }

        // Afficher l'erreur sans template pour tous les autres codes d'erreur
        $message = 'Une erreur est survenue : ' . $exception->getMessage();
        return new Response($message, $statusCode);
    }
}
