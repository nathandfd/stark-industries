<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Contract;
use App\Repository\ContractRepository;
use App\Repository\UserRepository;
use Knp\Bundle\SnappyBundle\KnpSnappyBundle;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Knp\Snappy\Pdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
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
    ): JsonResponse {

        $contract = $entityManager->getRepository(Contract::class)->find($contratid);
        $contract->setStatus($newstatus);
        $entityManager->flush();
        return new JsonResponse(true);
    }

    /**
     * @Route("/export", name="backoffice_export")
     */
    public function exportPdf(EntityManagerInterface $entityManager,Request $request, Pdf $pdf): Response
    {
        $contract = $entityManager->getRepository(Contract::class)->find($request->query->get('contratid'));

        $pdf->setBinary("\"../src/Wkhtmltopdf/bin/wkhtmltopdf.exe\"");
        $pdf->setTemporaryFolder("../var/cache");
        $html = $this->renderView(
            'backoffice/export.html.twig',
            array(
                'controller_name' => 'BackofficeController',
                'contrat' => $contract
            )
        );
        $response = new PdfResponse(
            $pdf->getOutputFromHtml($html),
            'contrat_'.$contract->getNumContrat().'.pdf'
        );
        $pdf->removeTemporaryFiles();
        return $response;
    }
}
