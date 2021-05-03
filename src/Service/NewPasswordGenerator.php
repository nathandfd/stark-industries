<?php


namespace App\Service;


use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Message;
use SymfonyCasts\Bundle\ResetPassword\Exception\ResetPasswordExceptionInterface;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;

class NewPasswordGenerator
{
    private $mailer;
    private $em;
    private $resetPasswordHelper;

    /**
     * NewPasswordGenerator constructor.
     */
    public function __construct(MailerInterface $mailer, EntityManagerInterface $em, ResetPasswordHelperInterface $resetPasswordHelper)
    {
        $this->mailer = $mailer;
        $this->em = $em;
        $this->resetPasswordHelper = $resetPasswordHelper;
    }

    public function createNewPassword(string $emailFormData)
    {
        $user = $this->em->getRepository(User::class)->findOneBy([
            'email' => $emailFormData,
        ]);

        // Do not reveal whether a user account was found or not.
//        if (!$user) {
//            return $this->redirectToRoute('app_check_email');
//        }

        try {
            $resetToken = $this->resetPasswordHelper->generateResetToken($user);
        } catch (ResetPasswordExceptionInterface $e) {
            // If you want to tell the user why a reset email was not sent, uncomment
            // the lines below and change the redirect to 'app_forgot_password_request'.
            // Caution: This may reveal if a user is registered or not.
            //
            // $this->addFlash('reset_password_error', sprintf(
            //     'There was a problem handling your password reset request - %s',
            //     $e->getReason()
            // ));

            //return $this->redirectToRoute('app_check_email');
        }

        $email = (new TemplatedEmail())
            ->from(new Address('contact@groupe-stark-industries.fr', 'Stark industries'))
            ->to($emailFormData)
            ->subject('Création d\'un nouveau mot de passe')
            ->htmlTemplate('reset_password/email.html.twig')
            ->context([
                'resetToken' => $resetToken,
            ])
        ;

        $this->mailer->send($email);

        // Store the token object in session for retrieval in check-email route.
        //$this->setTokenObjectInSession($resetToken);

        //return $this->redirectToRoute('app_check_email');
    }

}