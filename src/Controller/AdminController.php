<?php

namespace App\Controller;

use App\Controller\Admin\UserCrudController;
use App\Entity\User;
use App\Repository\UserRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminController
 * @package App\Controller
 * @Route("/admin")
 */
class AdminController extends AbstractDashboardController
{
    /**
     * @Route("/", name="admin_home")
     */
    public function index(): Response
    {
        $routeBuilder = $this->get(AdminUrlGenerator::class);

        return $this->redirect($routeBuilder->setController(UserCrudController::class)->generateUrl());
        //return $this->render('admin/index.html.twig');
        //return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Stark Industries')
            ;
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-users', Admin\UserCrudController::getEntityFqcn());
        yield MenuItem::linkToCrud('Distributeurs', 'fas fa-building', Admin\DistributorCrudController::getEntityFqcn());
        yield MenuItem::section();
        yield MenuItem::linkToCrud('Documents', 'fas fa-file-alt', Admin\DocumentsCrudController::getEntityFqcn());
        yield MenuItem::section();
        yield MenuItem::linkToRoute('Back-office', 'fas fa-file-signature', 'backoffice_home');
        yield MenuItem::section();
        yield MenuItem::linkToLogout('Déconnexion', 'fas fa-power-off');
    }
}
