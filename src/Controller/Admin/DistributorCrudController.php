<?php

namespace App\Controller\Admin;

use App\Entity\Distributor;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class DistributorCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Distributor::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_NEW, "Nouveau distributeur")
            ->setEntityLabelInSingular('distributeur')
            ->setEntityLabelInPlural('Distributeurs');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name','Entreprise'),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
         $actions
            ->update(Crud::PAGE_INDEX, Action::DELETE,function (Action $action){
                return $action->displayIf(function($entity){
                   return $entity->getUsers()->isEmpty();
                });
            });
        return parent::configureActions($actions);
    }
}
