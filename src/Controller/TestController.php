<?php

namespace App\Controller;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    /**
     * @Route("/test", name="test")
     */
    public function index(MailerInterface $mailer)
    {
      $email = new TemplatedEmail();
      $email
          ->from('oui@gmail.com')
          ->to('nathan.dufaud@gmail.com')
          ->subject('Création de votre compte')
          ->htmlTemplate('mail_template/welcome_email.html.twig')
          ->context([
              'resetToken' => [
                  'token'=>'oui',
                  'expirationMessageKey'=>'1'
              ],
              'name'=> '$name'
          ]);

      $mailer->send($email);

      return new Response('ok');
    }
}
