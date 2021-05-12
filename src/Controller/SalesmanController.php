<?php

namespace App\Controller;

use App\Entity\Contract;
use App\Entity\User;
use App\Form\SecureCodeValidationFormType;
use App\Repository\ContractRepository;
use App\Repository\DocumentRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Knp\Snappy\Pdf;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Message;
use Symfony\Component\Notifier\Message\SmsMessage;
use Symfony\Component\Notifier\TexterInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\NewContratRequestFormType;
use Symfony\Component\Validator\Exception\ValidatorException;

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
    public function newContract(Request $request){
		$contrat = new Contract();
		$form=$this->createForm(NewContratRequestFormType::class,$contrat);
		$form->handleRequest($request);
		if($form->isSubmitted() && $form->isValid()){
			$em = $this->getDoctrine()->getManager();

			$contrat->setSalesman($this->getUser());
			$contrat->setStatus(1);

			$infoClient = [
				'gender'=>$form->get('gender')->getData(),
				'lastname'=>$form->get('lastname')->getData(),
                'firstname'=>$form->get('firstname')->getData(),
                'birthdate'=>$form->get('birthday')->getData()->format('d/m/Y'),
                'address'=>$form->get('address')->getData(),
                'zipcode'=>$form->get('zipcode')->getData(),
                'city'=>$form->get('city')->getData(),
                'country'=>$form->get('country')->getData(),
                'phone'=>$form->get('phone')->getData(),
                'mobile'=>$form->get('mobile')->getData(),
                'mail'=>$form->get('mail')->getData(),
			];
			$contrat->setInfoClient($infoClient);

			$infoPrelevement = [
				'iban'=>$form->get('iban')->getData(),
				'bic'=>$form->get('bic')->getData(),
			];

			$contrat->setInfoPrelevement($infoPrelevement);
			$contrat->setNumeroVerif(000000);
			$contrat->setCreated(new \DateTime('now'));
			$em->persist($contrat);
			$em->flush();
			$em->refresh($contrat);

			$num_contrat = $this->getUser()->getMatricule();
			$num_contrat .= str_pad($contrat->getId(), 4, 0, STR_PAD_LEFT);;
			$contrat->setNumContrat($num_contrat);
			$em->flush();
			return new RedirectResponse($this->generateUrl('new-contract-validation',[
                'contractId'=>$contrat->getId()
            ]));
		}

		return $this->render('salesman/new-contract.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/new-contract-validation/{contractId}",name="new-contract-validation")
     */
    public function validNewContract(Request $request, TexterInterface $texter, ContractRepository $contractRepository, EntityManagerInterface $em, $contractId){
        $contract = $contractRepository->find($contractId);

        $form=$this->createForm(SecureCodeValidationFormType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            if ($contract->getNumeroVerif() == $form->get('secure_code')->getData()){
                $contract->setStatus(2);
                $em->flush();
                return new RedirectResponse($this->generateUrl('new-contract-valid',[
                    'contractId'=>$contractId
                ]));
            }
            $form->addError(new FormError('Le numéro de vérification est incorrect, un nouveau code va vous être envoyé par SMS'));
        }

        $secureCode = mt_rand(100000,999999);
        $contract->setNumeroVerif($secureCode);
        $clientInfos = $contract->getInfoClient();
        $em->flush();
//        $sms = new SmsMessage(
//            '+33'.(int)$clientInfos['mobile'],
//            'Afin de finaliser votre adhésion chez Stark Industries, veuillez communiquer le code suivant à votre conseiller : '.$secureCode.'. Merci de votre confiance.'
//        );
//        $sentMessage = $texter->send($sms);

        return $this->render('salesman/new-contract-validation.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/new-contract-valid/{contractId}", name="new-contract-valid")
     */
    public function sendMailNewContract(Pdf $pdf, MailerInterface $mailer, ContractRepository $contractRepository, $contractId){
        $contract = $contractRepository->find($contractId);
        $pdf->setBinary("\"../src/Wkhtmltopdf/bin/wkhtmltopdf.exe\"");
        $pdf->setTemporaryFolder("../var/cache");
        $pdf->generateFromHtml(
            $this->renderView(
                'backoffice/export.html.twig',
                array(
                    'controller_name' => 'BackofficeController',
                    'contrat' => $contract
                )),
            $pdf->getTemporaryFolder().'/contrat_'.$contract->getNumContrat().'.pdf'
        );
        $email = (new TemplatedEmail())
            ->from(new Address('contact@groupe-stark-industries.fr', 'Stark industries'))
            ->to($contract->getInfoClient()['mail'])
            ->subject('Souscription chez Stark industries')
            ->htmlTemplate('mail_template/new_contract.html.twig')
            ->context([
                'name'=> $contract->getInfoClient()['firstname']
            ])
            ->attachFromPath($pdf->getTemporaryFolder().'/contrat_'.$contract->getNumContrat().'.pdf', 'contrat_stark_industries.pdf')
        ;
        $mailer->send($email);
        $pdf->removeTemporaryFiles();
        unlink($pdf->getTemporaryFolder().'/contrat_'.$contract->getNumContrat().'.pdf');
        return new RedirectResponse($this->generateUrl('salesman_home'));
    }

    /**
     * @Route("/documents",name="salesman_documents")
     */
    public function listDocuments(DocumentRepository $documentRepository){

        $documents = $documentRepository->findAll();

        return $this->render('salesman/document.html.twig',[
            'documents'=>$documents
        ]);
    }
}
