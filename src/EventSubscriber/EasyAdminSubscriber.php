<?php


namespace App\EventSubscriber;


use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class EasyAdminSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => ['setUserEntity']
        ];
    }

    public function setUserEntity(BeforeEntityPersistedEvent $event){
        $entity = $event->getEntityInstance();

    }
}