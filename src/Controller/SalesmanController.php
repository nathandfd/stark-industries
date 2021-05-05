<?php

namespace App\Controller;

use App\Entity\Contract;
use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\NewContratRequestFormType;

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
			$contrat->setStatus(0);

			$infoClient = [
				'gender'=>$form->get('gender')->getData(),
				'lastname'=>$form->get('lastname')->getData(),
			];
			$contrat->setInfoClient($infoClient);

			$infoPrelevement = [
				'gender'=>$form->get('gender')->getData(),
				'lastname'=>$form->get('lastname')->getData(),
			];
			$contrat->setInfoPrelevement($infoPrelevement);
			$contrat->setNumeroVerif(1234);

			$em->persist($contrat);
			$em->flush();
			$em->refresh($contrat);

			$num_contrat = $this->getUser()->getMatricule();
			$num_contrat .= str_pad($contrat->getId(), 4, 0, STR_PAD_LEFT);;
			$contrat->setNumContrat($num_contrat);
			$em->flush();
			dd($contrat);

		}

		return $this->render('salesman/new-contract.html.twig', ['form' => $form->createView()]);
    }
}
