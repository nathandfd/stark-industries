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
        $contracts = [];
        $distributor = $this->getUser()->getDistributor();
        $salesmans = $distributor->getUsers();
        foreach ($salesmans as $key=>$salesman){
            if ($salesman->getRole() == "ROLE_SALESMAN"){
                foreach ($salesman->getContracts() as $key => $contract)
                $contracts[] = $contract;
            }
        }
        return $this->render('distributor/index.html.twig', [
            'controller_name' => 'DistributorController',
            'distributor'=>$distributor,
            'contracts'=>$contracts
        ]);
    }
}
