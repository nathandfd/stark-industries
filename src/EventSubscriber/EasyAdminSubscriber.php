<?php


namespace App\EventSubscriber;


use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Message;

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
        if ($event->getEntityInstance() instanceof User){
            $user = $event->getEntityInstance();
        }
    }

    public function sendMailAfterRegistration(AfterEntityPersistedEvent $event){
        if ($event->getEntityInstance() instanceof User){
            $user = $event->getEntityInstance();

            $email = new TemplatedEmail();
            $email
                ->from('contact@groupe-stark-industries.fr')
                ->to($user->getEmail())
                ->subject('Welcome to Stark Industries')
                ->htmlTemplate('mail_template/create_user.html.twig')
                ->context([
                    'name'=>$user->getFirstname(),
                    'mail'=>$user->getEmail()
                ]);
            $this->mailer->send($email);
        }

    }
}