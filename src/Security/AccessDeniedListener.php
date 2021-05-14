<?php


namespace App\Security;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class AccessDeniedListener implements EventSubscriberInterface
{
    private $url;

    public function __construct(UrlGeneratorInterface $url){
        $this->url = $url;
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents()
    {
        return[
          KernelEvents::EXCEPTION => [
              'onKernelException',
              2
          ]
        ];
    }

    public function onKernelException(ExceptionEvent $event):void
    {
        $exception = $event->getThrowable();

        if (!$exception instanceof AccessDeniedException){
            return;
        }

        $event->setResponse(new RedirectResponse($this->url->generate('app_login')));
    }
}