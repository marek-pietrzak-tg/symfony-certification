<?php

namespace AppBundle\EventListener;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

class KernelListener
{
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $response = $this->getResponseForContentType($event);
        $event->setResponse($response);
    }

    private function getResponseForContentType(GetResponseForExceptionEvent $event)
    {
        $contentType = $event->getRequest()->getContentType();
        $exception = $event->getException();

        if ('json' === $contentType) {
            $message = ['message' => $exception->getMessage(), 'code' => $exception->getCode()];
            return new JsonResponse($message, 500);
        }

        $message = sprintf(
            "The error occurred. Message: '%s' with the code: %s",
            $exception->getMessage(),
            $exception->getCode()
        );

        return new Response($message, 500);
    }
}