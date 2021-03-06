<?php

namespace App\Controller\Admin;

use App\Entity\Document;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\DomCrawler\Field\FileFormField;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;

class DocumentsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Document::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('document')
            ->setEntityLabelInPlural('Documents');
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name','Nom du fichier'),
            ImageField::new('path','Fichier à importer')
                ->setBasePath('assets/documents')
                ->setUploadDir('public/assets/documents')
        ];
    }

    public function deleteEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        unlink('assets/documents/'.$entityInstance->getPath());
        parent::deleteEntity($entityManager, $entityInstance);
    }
}
