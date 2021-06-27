<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ResponseListener
{
    public function onKernelException(ExceptionEvent $event)
    {
        $message = json_encode(['message' => 'Please give a valid body!']);

        $response = new Response();
        $response->setContent($message);

        $event->setResponse($response);
    }
}
