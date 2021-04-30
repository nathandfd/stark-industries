<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SalesmanController extends AbstractController
{
    /**
     * @Route("/salesman", name="salesman")
     */
    public function index(): Response
    {
        return $this->render('salesman/index.html.twig', [
            'controller_name' => 'SalesmanController',
        ]);
    }
}
