<?php

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\ResponseEvent;

class CorsListener
{
    public function onKernelResponse(ResponseEvent $event): void
    {
        $response = $event->getResponse();

        // Ajouter les en-têtes CORS
        $response->headers->set('Access-Control-Allow-Origin', 'http://localhost:4200');
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization');
        $response->headers->set('Access-Control-Allow-Credentials', 'true');

        // Gérer les requêtes OPTIONS (pré-requêtes CORS)
        if ($event->getRequest()->getMethod() === 'OPTIONS') {
            $response->setStatusCode(200);
            $response->setContent('');
            $event->stopPropagation();
        }
    }
}
