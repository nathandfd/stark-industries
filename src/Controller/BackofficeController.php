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
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Message;
use Symfony\Component\Routing\Annotation\Route;
use ZipArchive;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
        $contrats = $contractRepository->findAll();

        return $this->render('backoffice/index.html.twig', [
            'controller_name' => 'BackofficeController',
            'contrats' => $contrats
        ]);
    }

    /**
     * @Route("/status-update/{contratid}/{newstatus}", name="status_update")
     */
    public function updateStatus(
        $contratid,
        $newstatus,
        EntityManagerInterface $entityManager,
        MailerInterface $mailer
    ): JsonResponse {
        if ($newstatus != 3 && $newstatus != 4 && $newstatus != 5 && $newstatus != 6 && $newstatus != 7){
            return new JsonResponse(false);
        }
        $contract = $entityManager->getRepository(Contract::class)->find($contratid);
        $contract->setStatus($newstatus);
        $contract->setDuplicate(false);
        $entityManager->flush();
        if ($newstatus == 4){
            $email = (new TemplatedEmail())
                ->from(new Address('contact@groupe-stark-industries.fr', 'Stark industries'))
                ->to($contract->getInfoClient()['mail'])
                ->subject('Confirmation de résiliation chez Stark industries')
                ->htmlTemplate('mail_template/cancellation_mail.html.twig')
                ->context([
                    'name'=> $contract->getInfoClient()['firstname']
                ]);

            $mailer->send($email);
        }
        return new JsonResponse(true);
    }
}