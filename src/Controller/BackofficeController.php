<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Contract;
use App\Repository\ContractRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/backoffice")
 */
class BackofficeController extends AbstractController
{
    /**
     * @Route("/", name="backoffice_home")
     */
    public function index(UserRepository $userRepository, ContractRepository $contractRepository): Response
    {
        $backoffice =  $userRepository->findByRoles(['ROLE_BACKOFFICE']);
        $salesman = $userRepository->findByRoles(['ROLE_SALESMAN']);



        $contrats = $contractRepository->findAll();
        return $this->render('backoffice/index.html.twig', [
            'controller_name' => 'BackofficeController',
            'salesman' => $salesman,
            'contrats' => $contrats,
            'backoffice' => $backoffice
        ]);
    }

    /**
     * @Route("/status-update/{contratid}/{newstatus}", name="status_update")
     */
    public function updateStatus(
        $contratid,
        $newstatus,
        EntityManagerInterface $entityManager
    ): Response {

        $contract = $entityManager->getRepository(Contract::class)->find($contratid);
        $contract->setStatus($newstatus);
        $entityManager->flush();
        return new Response(true);
    }
}
