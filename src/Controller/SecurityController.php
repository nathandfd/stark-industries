<?php

namespace App\Controller;

use LogicException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AuthenticationServiceException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Form\UserRegistrationFormType;
use App\Entity\Contract;
use App\Entity\User;



class SecurityController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function redirectToLogin(){
        return new RedirectResponse($this->generateUrl('app_login'));
    }
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils, Request $request): Response
    {
         if ($this->getUser()) {
             switch ($this->getUser()->getRoles()[0]){
                 case 'ROLE_SALESMAN':
                     return $this->redirectToRoute('salesman_home');
                     break;
                 case 'ROLE_ADMIN':
                     return $this->redirectToRoute('backoffice_home');
                     break;
                 case 'ROLE_DISTRIBUTOR':
                     return $this->redirectToRoute('distributor_home');
                     break;
                 default:
                     return $this->redirectToRoute('error');
                     break;
             }
         }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }


}
