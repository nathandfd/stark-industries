<?php

namespace App\Controller;

use App\Entity\Contract;
use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/salesman")
 */
class SalesmanController extends AbstractController
{
    /**
     * @Route("/", name="salesman_home")
     */
    public function index(EntityManagerInterface $em): Response
    {
        $salesman = $this->getUser();
        $contrats = $salesman->getContracts();
        return $this->render('salesman/index.html.twig', [
            'controller_name' => 'SalesmanController',
            'salesman' => $salesman,
            'contrats' => $contrats
        ]);
    }

    /**
     * @Route("/new-contract", name="new-contract")
     */
    public function newContract(){
        return $this->render('salesman/new-contract.html.twig');
    }
}
