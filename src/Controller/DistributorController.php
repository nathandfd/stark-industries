<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DistributorController extends AbstractController
{
    /**
     * @Route("/distributor", name="distributor_home")
     */
    public function index(EntityManagerInterface $em, UserRepository $userRepository): Response
    {
        $contracts = [];
        $distributor = $this->getUser()->getDistributor();
        $salesmans = $distributor->getUsers();
        foreach ($salesmans as $key=>$salesman){
            if ($salesman->getRole() == "ROLE_SALESMAN"){
                foreach ($salesman->getContracts() as $key2 => $contract)
                    $contracts[] = $contract;
            }
        }
        return $this->render('distributor/index.html.twig', [
            'controller_name' => 'DistributorController',
            'distributeur'=>$distributor,
            'contrats'=>$contracts
        ]);
    }
}
