<?php

namespace App\Controller;

use App\Form\ChangePasswordFormType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Notifier\Message\SmsMessage;
use Symfony\Component\Notifier\TexterInterface;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    private $texter;
    /**
     * TestController constructor.
     */
    public function __construct(TexterInterface $texter)
    {
        $this->texter = $texter;
    }

    /**
     * @Route("/test", name="test")
     */
    public function index()
    {


    }
}
