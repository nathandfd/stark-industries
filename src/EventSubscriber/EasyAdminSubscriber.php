<?php


namespace App\EventSubscriber;


use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class EasyAdminSubscriber implements EventSubscriberInterface
{
    private $mailer;
    /**
     * EasyAdminSubscriber constructor.
     */
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => ['setUserEntity'],
            AfterEntityPersistedEvent::class => ['sendMailAfterRegistration']
        ];
    }

    public function setUserEntity(BeforeEntityPersistedEvent $event){
        $entity = $event->getEntityInstance();

    }

    public function sendMailAfterRegistration(AfterEntityPersistedEvent $event){
        $email =new Email();
        $email
            ->from('nathan.dufaud@gmail.com')
            ->to('nathan.dufaud@gmail.com')
            ->subject('Welcome to Stark Industries')
            ->text('Salut');
        $this->mailer->send($email);
    }
}