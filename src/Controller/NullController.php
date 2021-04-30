<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NullController extends AbstractController
{
    /**
     * @Route("/null", name="null")
     */
    public function index(): Response
    {
        return $this->render('null/index.html.twig', [
            'controller_name' => 'NullController',
        ]);
    }
}
