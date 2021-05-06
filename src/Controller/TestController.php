<?php

namespace App\Controller;

use App\Form\ChangePasswordFormType;
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
        $form = $this->createForm(ChangePasswordFormType::class);
        return $this->render('reset_password/reset.html.twig', [
            'resetForm' => $form->createView(),
        ]);
    }
}
