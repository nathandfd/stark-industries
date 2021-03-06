<?php

namespace App\Controller\Admin;

use App\Controller\ResetPasswordController;
use App\Entity\Distributor;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\DomCrawler\Field\ChoiceFormField;
use Symfony\Component\Form\ChoiceList\ArrayChoiceList;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_NEW, "Nouvel utilisateur")
            ->setEntityLabelInSingular('utilisateur')
            ->setEntityLabelInPlural('Utilisateurs');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            EmailField::new('email', 'Email'),
            TextField::new('name', 'Nom'),
            TextField::new('firstname', 'Prénom'),
            ChoiceField::new('role','Rôle')
                ->setChoices([
                    "Back-office"=>"ROLE_ADMIN",
                    "Commercial"=>"ROLE_SALESMAN",
                    "Distributeur"=>"ROLE_DISTRIBUTOR"
                    ])
                ->addCssClass('role-input'),
            TextField::new('matricule','Matricule')
                ->onlyOnDetail()
                ->formatValue(function($value){
                    return $value?:'Aucun matricule disponible';
                }),
            AssociationField::new('distributor', 'Distributeur')
                ->addCssClass('distributor-input')
                ->addJsFiles('/build/showdistributor.js')
                ->formatValue(function($value){
                    return $value?:'Aucun distributeur associé';
                })
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        $disableUser = Action::new('disableUser','Désactiver')
            ->linkToCrudAction('disableUser')
            ->displayIf(function($entity){
                return $entity->getRole() == "ROLE_SALESMAN" && $entity->isActive();
            })
            ->addCssClass("text-danger");;

        $enableUser = Action::new('enableUser','Activer')
            ->linkToCrudAction('enableUser')
            ->displayIf(function($entity){
                return $entity->getRole() == "ROLE_SALESMAN" && !$entity->isActive();
            })
            ->addCssClass("text-success");

        $actions
            ->add(Crud::PAGE_INDEX, $disableUser)
            ->add(Crud::PAGE_INDEX, $enableUser)
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->remove(Crud::PAGE_INDEX, Action::BATCH_DELETE)
            ->update(Crud::PAGE_INDEX, Action::NEW, function(Action $action){
                return $action->setLabel("Créer un nouvel utilisateur");
                })
            ->update(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER, function(Action $action){
                return $action->setLabel("Créer et ajouter un nouvel utilisateur");
            })
            ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action){
                return $action->displayIf(function($entity){
                    return $entity->getRole() != "ROLE_SALESMAN" && $this->getUser() != $entity;
                });
            })
            ->reorder(Crud::PAGE_INDEX, [Action::DETAIL, Action::EDIT, Action::DELETE, 'enableUser', 'disableUser'])
        ;
        return parent::configureActions($actions);
    }

    public function disableUser(AdminContext $adminContext){
        $user = $adminContext->getEntity()->getInstance();
        $user->setActive(false);
        $this->getDoctrine()->getManager()->flush();
        return $this->redirect($adminContext->getReferrer());
    }

    public function enableUser(AdminContext $adminContext){
        $user = $adminContext->getEntity()->getInstance();
        $user->setActive(true);
        $this->getDoctrine()->getManager()->flush();
        return $this->redirect($adminContext->getReferrer());
    }
}
