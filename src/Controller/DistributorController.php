<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DistributorController extends AbstractController
{
    /**
     * @Route("/distributor", name="distributor_home")
     */
    public function index(): Response
    {
        return $this->render('distributor/index.html.twig', [
            'controller_name' => 'DistributorController',
        ]);
    }
}
