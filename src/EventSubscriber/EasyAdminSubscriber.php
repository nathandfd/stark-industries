<?php


namespace App\EventSubscriber;


use App\Controller\ResetPasswordController;
use App\Entity\Distributor;
use App\Entity\ResetPasswordRequest;
use App\Entity\User;
use App\Service\NewPasswordGenerator;
use Doctrine\DBAL\Exception\ConstraintViolationException;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityDeletedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Exception\ForbiddenActionException;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Message;

class EasyAdminSubscriber implements EventSubscriberInterface
{
    private $mailer;
    private $passwordGenerator;
    /**
     * EasyAdminSubscriber constructor.
     */
    public function __construct(MailerInterface $mailer, NewPasswordGenerator $passwordGenerator)
    {
        $this->mailer = $mailer;
        $this->passwordGenerator = $passwordGenerator;
    }

    public static function getSubscribedEvents()
    {
        return [
            AfterEntityPersistedEvent::class => ['sendMailAfterRegistration'],
        ];
    }

    public function sendMailAfterRegistration(AfterEntityPersistedEvent $event){
        if ($event->getEntityInstance() instanceof User){
            $user = $event->getEntityInstance();
            if ($user->getRole() === "ROLE_SALESMAN"){
                $user->setMatricule(str_pad($user->getId(), 4, 0, STR_PAD_LEFT));
            }
            $this->passwordGenerator->createNewPassword($user->getEmail(), $user->getFirstname());
        }

    }
}