<?php

namespace Troiswa\PublicBundle\Services\Listener;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class PreMethodListener
{
    public function PreMethod(FilterControllerEvent $event)
    {
        if (HttpKernelInterface::MASTER_REQUEST == $event->getRequestType()) {
            $controller = $event->getController(); //renvoi un tableau avec un seul resultat...
            if (isset( $controller[0] )) {
                $controller = $controller[0]; // on re attribue le résultat à $controller
                if (method_exists($controller, 'preExecute')) {
                    $controller->preExecute();
                }
            }
        }

    }
}
