<?php

namespace App\Controller\Admin;

use App\Entity\Recruiter;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class RecruiterCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Recruiter::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm()->hideOnIndex();
        yield TextField::new('compagnyName')->setLabel('Entreprise');
        yield TextField::new('adress')->setLabel('Adresse');
        yield BooleanField::new('isValid')->setLabel('Entreprise valide ?');
        yield CollectionField::new('announcements', 'offres d\'emploi déposées')->hideOnForm();
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'Liste des recruteurs');
    }
}
