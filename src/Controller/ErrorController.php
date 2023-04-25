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

        $template = 'error/' . $statusCode . '.html.twig'; // Valeur par défaut

        if ($statusCode !== 404) {
            $content = $exception->getMessage();

            return new Response(
                $this->container->get('twig')->render(
                    $template,
                    ['exception' => FlattenException::create($exception), 'status_code' => $statusCode, 'status_text' => Response::$statusTexts[$statusCode], 'content' => $content]
                ),
                $statusCode
            );
        }
    }
}
